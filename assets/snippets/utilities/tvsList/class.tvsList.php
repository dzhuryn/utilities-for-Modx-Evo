<?php
class tvsList{
  /** @var  DocumentParser */
    public $modx;
    public $config;

    public $T;
    public $TVR;
    public $data = [];
    public $notIn = [];
    public $params = [];


    /**
     * tvsList constructor.
     * @param $modx
     * @param $params
     */
    public function __construct($modx, $params)
    {
        $this->modx = $modx;
        $this->config = [
            'rowTpl'=>'@CODE:<tr><td>[+name+]</td><td>[+value+]</td></tr>',
            'outerTpl'=>'@CODE:<table >[+wrapper+]</table>',
            'selectType'=>'category',
            'id'=>$this->modx->documentIdentifier,
        ];
        $this->T = $this->modx->getFullTableName('site_tmplvars');
        $this->TVR = $this->modx->getFullTableName('site_tmplvar_contentvalues');
        $this->config = array_merge($this->config,$params);

        $this->params = $params;

      //  var_dump($this->modx->getTpl($this->config['rowTpl']));


       $this->config['rowTpl'] = $this->modx->getTpl($this->config['rowTpl']);
        $this->config['outerTpl'] = $this->modx->getTpl($this->config['outerTpl']);



        $this->getNotIn();
    }
    public function getNotIn(){
        if(!empty($this->config['notDocId'])){
            $data = $this->modx->runSnippet('DocInfo',[
                'field'=>'notIn',
                'docid'=>intval($this->config['notDocId']),
            ]);
            $data = json_decode($data,true)['fieldValue'];
        }
        if(!empty($data) && is_array($data)){
            foreach ($data as $el) {
                $this->notIn[$el['tv']] = true;
            }
        }
        if(!empty($this->config['excludeTvs'])){
            $resp = explode(',',$this->config['excludeTvs']);
            if(is_array($resp)){
                foreach ($resp as $item) {
                    $this->notIn[$item] = true;
                }
            }
        }
    }
    public function getTvs(){
        $docId  = intval($this->config['id']);
        $catResp = explode(',',$this->config['category']);
        $category = [];
        foreach ($catResp as $elem) {
            $category[]="'".$this->modx->db->escape($elem)."'";
        }
        $tvsResp = explode(',',$this->config['tvs']);
        $tvs = [];
        foreach ($tvsResp as $elem) {
            $tvs[]="'".$this->modx->db->escape($elem)."'";
        }
        $template = $this->modx->documentObject['template'];
        $TT  = $this->modx->getFullTableName('site_tmplvar_templates');
        $sql = "SELECT * 
                FROM ". $this->T .",$TT,$this->TVR
                WHERE $this->T .id =  $this->TVR.tmplvarid  and $TT.tmplvarid = $this->T.id 
                      and $TT.templateid = '.$template.' and  contentid = ". $docId ;
        switch ($this->config['selectType']){
            case 'category':
                if(!empty($category)){
                    $sql .=" AND category IN( ". implode(',',$category) .") ";
                }
                break;
            case '*':
                break;
            case 'tvs':
                if(!empty($tvs)) {
                    $sql .= " AND name IN( " . implode(',',$tvs) . ") ";
                }
                break;
        }
        $sql .= " order by $TT.rank";
        $this->data = $this->modx->db->makeArray($this->modx->db->query($sql));
    }
    public function prepareName($name){
        return $name['caption'];
    }
    public function render(){
        $this->getTvs();
        $data = $this->data;
        $itemStr = '';
        foreach ($data as $key=> $item) {


            if(!empty($this->notIn[$item['name']])){
                continue;
            }
            if(empty($item['value'])){
                continue;
            }
            $tvName = $item['name'];
            $name =$this->prepareName($item);
            $value = $item['value'];
            $defaultValue = $this->modx->runSnippet('default',['name'=>$item['name'],'val'=>$item['value']]);
            if(!empty($defaultValue)){
                $value = $defaultValue;
            }

            $class = $key % 2==0?'odd':'even';


            $rowTpl = !empty($this->params['rowTpl_'.$tvName])?$this->modx->getTpl($this->params['rowTpl_'.$tvName]):$this->config['rowTpl'];
            $itemStr .= $this->modx->parseText($rowTpl,[
                'name'=>$name,
                'value'=>$value,
                'value_full'=>$item['value'],
                'tvName'=>$tvName,

                'class'=>$class
            ]);
        }
        $outer = $this->modx->parseText($this->config['outerTpl'],['wrapper'=>$itemStr]);
        return $outer;

    }
}