<?php

    $usr = new UserAccount("login", "pass","Ivan", "Ivanpv", "Iv.");
    $usr1 = new UserAccount("childLogin", "childPass", "Peter", "Petrov", "P"); //второй юзер для дочерок
    
    $ur = new UserRepository;            
    echo "user_login: ".$usr->login."<br />";
    
    $id = $ur->Save($usr);
    $cid = $ur->Save($usr1);
    
    $ugr = new UserGroup($id, "Имя группы", "Глава группы", null);
    $ugr2 = new UserGroup($id, "Ещё одна группа", "Глава группы", null);
    
    $ugrRep = new UserGroupRepository();
    $newID = $ugrRep->Save($ugr);    
    if($newID > 0)
        {
            echo "Группа сохранена под id: $newID<br />";
        }
    else 
        {
            echo "Ошибка сохранения группы: ".$ugrRep->GetError()." <br />";
        }
        
    $newID2 = $ugrRep->Save($ugr2); //сейвим втрую втихую
    
    echo "Пробуем получить группу по id... <br />";
        
    $newGr = $ugrRep->GetById($newID);
    if($newGr)
    {
        echo "Имя полученной: ".$newGr->name."<br />";
    }
    else 
    {
        echo "Ошибка получения группы: ".$ugrRep->GetError()." <br />";
    }
        
    //htlfrnbhetv
    $newGr->name = "Имя группы 222";
    $res = $ugrRep->Save($newGr);
    if($res)
    {
       echo "Имя отредактированной группы: ".$newGr->name."<br />";
    }
    else 
    {
        echo "Ошибка редактирования группы: ".$ugrRep->GetError()." <br />";
    }
    
    //добавляем пару шаблонов
    $newGr = $ugrRep->AddNewDocTemplateToCollection($newGr, 1, "имя шаблона");
    $newGr = $ugrRep->AddNewDocTemplateToCollection($newGr, 2, "имя шаблона222");

    echo "Шаблоны добавлены! <br />";

    $tpl = $newGr->GetRelatedDocTemplates();
    if($tpl)
        {
            foreach($tpl as $item)
                {
                    echo "Имя шаблона группы: ".$item->name."<br />";
                }
        }
        else
            echo "Ошибка добавления шаблона: ".$ugrRep->GetError()." <br />";
        
     //добавляем дочерок
     $cUg = new UserGroup($cid, "Дочерняя группо", "Глаавный по дочерке", $newID);
     $cugID = $ugrRep->Save($cUg);
     echo "Создана дочерняя группа для группы $newID. ид дочерней $cugID <br />";
     //получаем родителяч дочерки:
     $par = $ugrRep->GetParentUserGroup($cUg);
     if($par)
     {
         echo "Имя родителя: ".$par->name."<br />";
     }
     else 
     {
        echo "Не нашли родителя!";
     }
     
     //пробуем получить детей по родителю
     echo "ищем у родителя детей <br />";
     $childList = $ugrRep->GetChildList($par);
     if($childList)
     {
         foreach($childList as $chld)
         {
             echo "Дитё - ".$chld->name."<br />";
         }                          
     }
     else echo "Детей не нашлость <br />";
     //ищем теплейты для дитя
     $mainChild = $childList[0];
     $tpl = $ugrRep->GetUserGroupDocTemplatesFromParentGroup($mainChild);
     if($tpl)
     {
         foreach($tpl as $item)
         {
             echo "Шаблон для щаполнения дочеркой - ".$item->name."<br />";
         }                          
     }
     else echo "Шаблонов не нашлость <br />";

                
?>
