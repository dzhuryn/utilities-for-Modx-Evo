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
5. Шаблон строчки из названием и значением параметра 
       
Если `selectType` указано `category`, то список категорый указываем в параметре `category`, параметр `tvs` не используем.  
Если `selectType` указано `tvs`, то список тв параметров указываем в параметре `tvs`, параметр `category` не используем.  

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
        
### evoSortBlock
Сниппет для формирования блока сортировки. Из приятных вещей.
1. Удобная кастомизация.
2. Ajax совместимый из eFilter


##### Параметры
1. displayConfig  настройка селекта или ссылок для указания количества товаров на странице. Пример: 20||30||40||все==all.  
2. sortConfig  настройка  ссылок для указания поля по которому товары сортируються. Пример: По название==pagetitle||По индексу==menuindex
3. ajax - использовать ли ajax по умолчанию ноль.

##### Шаблоны
1. ownerTpl - Основная обертка блока.  
    Плейсхолдеры ```[+class+] [+display.block+] [+sort.block+]```.  
    Пример: ```<div class="[+class+]">[+display.block+][+sort.block+]</div>```
2. displayOwnerTpl - обертка блока для выбора количества елементов на странице.  
    Плейсхолдеры: ```[+class+]">[+wrapper+]```  
    Пример: ```<select class="[+class+]">[+wrapper+]</select>```  
    Пример: ```<div class="[+class+]">[+wrapper+]</div>```
3. displayRowTpl - Шаблон вывода строки. ( option для селекта или тег a для блока).  
    Плейсхолдеры: ```[+value+],[+selected+],[+data+],[+class+],[+caption+] ```  
    Пример: ``` <option value="[+value+]" [+selected+] >[+caption+]</option>```  
    Пример: ``` <a [+data+] class="[+class+]">[+caption+]</a> ```  

4. sortOwnerTpl  - обертка блока для выбора поля по которому елементы сортируються на странице.  
    Плейсхолдеры: ```[+wrapper+]``` 
    Пример: ```<ul>[+wrapper+]</ul>``` 
    
5. sortRowTpl - Шаблон вывода ссылки для выбора поля.
        Плейсхолдеры: ```[+class+],[+data+] [+caption+]``` 
        Пример: ```<a class="[+class+]" [+data+]>[+caption+]</a>``` 
        
##### Классы       
1. displayActiveClass - Клас для активного пунка в выборе количеста елементов на странице.
2. sortActiveClass - Клас для активного пунка в выборе поля для сортировки елементов на странице.
3. sortUpClass - Класс когда сортировка от маленького к большому
4. sortDownClass - Класс когда сортировка от большого к маленькому

##### Значения по умолчаеию
1. displayDefault - количество елементов на странице по умолчанию
2. sortFieldDefault - поле сортировки по умолчанию
3. sortOrderDefault - направление сортировки по умолчанию

##### Пример
    [!evoSortBlock?
        &ownerTpl=`<div  class="sorting-block__filters [+class+]"><form action="#">[+display.block+][+sort.block+]</form></div>`
        &displayOwnerTpl=`<div class="sorting-block__filters-amount"><span class="sorting-block__filters-label">Показывать:</span><div class="sorting-block__select"><div class="inline-select"><select class="decor-select js-select[+class+]">[+wrapper+]</select></div></div></div>`
        &sortOwnerTpl=`<div class="sorting-block__filters-type"><span class="sorting-block__filters-label sorting-block__filters-label--type">Сортировать:</span><div class="sorting-block__filters-block"><span class="sorting-block__filters-mobile-active"><span class="sorting-block__filters-mobile-active-inner">По популярности</span></span><ul class="sorting-block__filters-list">[+wrapper+]</ul></div></div>`
        &sortRowTpl=`<li class="sorting-block__filters-item"><a href="#"  [+data+] [+selected+]  class="sorting-block__filters-link [+class+]">[+caption+]</a></li>`
        &sortActiveClass=`is-active`
        &sortConfig=`Название==pagetitle||Дата поступления==menuindex||Цена==price`
        &ajax=`1`
    !]