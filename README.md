## Репозиторый из полесзными сниппетами, плагинами и js кодом


## Снипеты

### firstImage - выводит первую картикну из multiTv
   
   mode  - режым вывода ( return / echo ) по умолчанию return  
   num  - номер картинки начиная с нуля по умолчанию первая  
   input -    json масив MultiTV  
   options -  правильно для phpthumb  
   key ключ -  елемента в масиве по умолчанию image  
   
### getElements Получение значений для select в админке из дерева
   
type уткуда брать из дерева 'doc'  
parent id родителя откуда брать документы  
key поле для идентификатора   
   
    Пример @EVAL return $modx->runSnippet("getElements", array("key"=>"id","parent"=>"10474"));
    
### default
Получание значение а не id для тв полей где указано возможние значения
тоесть не yes для чекбокса, а да
    
    Пример [[default? &name=`producer` &val=`[+producer+]`]]

    
   