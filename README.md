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

    
### Sale   Получение скидки на основании процента или старой цены
Если занада цена и старая получаем процент скидки.
Если задана цена и процент получаем цену со скидкой

afterPoint количество знаков после комы  
price  цена  
oldPrice  старая цена  
percent  процент  

    [[sale? &price=`500` &oldPrice=`1890`]]
    [[sale? &price=`124.555` &percent=`5`]]
    
### plural склонение слов к числу

n число к которому слова склоняються
lang  язык (ru,ua,en)
t1 Текст 1
t2 Текст 1
t3 Текст 1

    Пример [[plural? &n=`1` &t1=`отзыв` &t2=`отзыва` &t3=`отзывов`]]

### getDocCount получение количества документов в папке
Выборка по параметрам DocLister  
round - округление в большую сторону. Если надо вывести не 121 , а 200 указываем round 0 ;  
 
    Пример: [[getDocCount? &parents=`2`]]
    Пример: [[getDocCount? &parents=`2` &round=`2`]]
    

### tvsList  вывод списка тв параметров для документа
Снипет удобен когда надо вывеси таблицу с характеристиками товара  
Для подстановки значеный из дерева в место id необходимый сниппет default

1. selectType - тип выборки:  
    * `*` - выбераем все тв параметры
    * `category` - выбераем тв параметры из определьонных категорий, указаных в параметре `category` через зап'ятую 
    * `tvs` - выбераем тв параметры указаные в параметре `tvs`
    

2. id - id докумнта для которого надо вывести список
3. notDocId - id документа где в мульти тв параметре notIn  указаны тв параметры которые не надо выводить
3. excludeTvs - список тв параметров которые на надо выводить через зап'ятаю
4. Шаблон обертки        
5. Шаблон строчки из название и значением параметра 
       
        [[tvsList?
            &id=`7919`
            &selectType=`category`
            &category=`23`
            &tvs=`tip_podveski,diametr_koles`
            &notDocId=`1`
            &excludeTvs = `vilka,pokryshka_perednyaya`
            &outerTpl=`@CODE:<ul class="characrteristics__list  characrteristics__list--indent">[+wrapper+]</ul>`
            &rowTpl=`@CODE:<li class="characrteristics__list-item"><span class="characrteristics__list-title">[+name+]</span><span class="characrteristics__list-info">[+value+]</span></li>`   
        ]]