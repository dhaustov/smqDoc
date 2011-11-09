<?php
require_once 'Init.php';
/*
 * Test file for P. Serdukov
 * 
 */
echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"></head><body>";

echo "Create Rep <br>";
/* @var $dtpRep DocTemplateRepository */
$dtpRep = new DocTemplateRepository;
echo 'Create 1 DT<br>';
/* @var $docTpl1 DocTemplate */
$docTpl1 = new DocTemplate;
$docTpl1->name = "тестовый темплейт";
$docTpl1->fieldsList = array();
echo 'Create  DT f1<br>';
/*@var $docTpl1F1 DocTemplateField*/
$docTpl1F1 = new DocTemplateField;
$docTpl1F1->id  = -3;
$docTpl1F1->name = "dt1f1";
$docTpl1F1->isCalculated = false;
$docTpl1F1->fieldType = $dtpRep->docTemplateFieldTypesArr[1];
$docTpl1F1->operation = $dtpRep->docTemplateOperationsArr[1];
$docTpl1F1->isRestricted = false;
$docTpl1F1->minVal  = 10;
$docTpl1F1->maxVal = 20;
$docTpl1->fieldsList[$docTpl1F1->id] = $docTpl1F1;
echo 'Create  DT f2<br>';
/*@var $docTpl1F2 DocTemplateField*/
$docTpl1F2 = new DocTemplateField;
$docTpl1F2->id  = -2;
$docTpl1F2->name = "dt1f2";
$docTpl1F2->isCalculated = true;
$docTpl1F2->fieldType = $dtpRep->docTemplateFieldTypesArr[2];
$docTpl1F2->operation = $dtpRep->docTemplateOperationsArr[1];
$docTpl1F2->isRestricted = true;
$docTpl1F2->minVal  = 15;
$docTpl1F2->maxVal = 70;
$docTpl1->fieldsList[$docTpl1F2->id] = $docTpl1F2;
echo 'Create  DT f3<br>';
/*@var $docTpl1F3 DocTemplateField*/
$docTpl1F3 = new DocTemplateField;
$docTpl1F3->id  = -1;
$docTpl1F3->name = "dt1f3";
$docTpl1F3->isCalculated = false;
$docTpl1F3->fieldType = $dtpRep->docTemplateFieldTypesArr[1];
$docTpl1F3->operation = $dtpRep->docTemplateOperationsArr[1];
$docTpl1F3->isRestricted = true;
$docTpl1F3->minVal  = 10;
$docTpl1F3->maxVal = 200;
$docTpl1->fieldsList[$docTpl1F3->id] = $docTpl1F3;

$dtpRep->Save($docTpl1);

//создаем пользователя для теста
$usr = new UserAccount("login".rand(100, 1000), "pass","Ivan".rand(100, 1000), "Ivanpv".rand(100, 1000), "Iv.");
$ur = new UserRepository;            
$id = $ur->Save($usr);

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$usr = $ur->GetById($id); //вот теперь в $usr есть id
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


//создаем гурппу для теста
//$ugr = new UserGroup($id, "Имя группы", "Глава группы", $usr);
$ugr = new UserGroup($id, "Имя группы".rand(100, 1000), "Глава группы".rand(100, 1000));
$ugrRep = new UserGroupRepository();
$ugrID = $ugrRep->Save($ugr);


//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!/
$ugr = $ugrRep->GetById($ugrID);
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

/* @var $ugdRep UserGroupDocRepository */
$ugdRep = new UserGroupDocRepository();

//Создаем документ 1

$ugDoc1F1 = new UserGroupDocField($docTpl1F1,"test",null,null);
$ugDoc1F2 = new UserGroupDocField($docTpl1F2,null,1,null);
$ugDoc1F3 = new UserGroupDocField($docTpl1F3,"null",null,null);

$ugDoc1 = new UserGroupDoc(Array($ugDoc1F1,$ugDoc1F2,$ugDoc1F3));
$ugDoc1->author = $usr;
$ugDoc1->dateCreated = null;
$ugDoc1->group = $ugr;
$ugDoc1->groupDocTempl = $docTpl1;
$ugDoc1->status = EnUserGroupDocStatus::EDITED;
$ugDoc1->lastChangedDate = null;

if($ugdRep->Save($ugDoc1))
    echo "Документ 1 сохранен id документы $ugDoc1->id<br>";
else
    echo "Ошибка сохранения документы ".$ugdRep->GetError()."<br>";

//Создаем документ 2

$ugDoc2F1 = new UserGroupDocField($docTpl1F1,"test2",null,null);
$ugDoc2F2 = new UserGroupDocField($docTpl1F2,null,1,null);
$ugDoc2F3 = new UserGroupDocField($docTpl1F3,"null2",null,null);

$ugDoc2->fieldsList = Array($ugDoc2F1,$ugDoc2F2,$ugDoc2F3);


$ugDoc2 = new UserGroupDoc(Array($ugDoc2F1,$ugDoc2F2,$ugDoc2F3));
$ugDoc2->author = $usr;
$ugDoc2->dateCreated = null;
$ugDoc2->group = $ugr;
$ugDoc2->groupDocTempl = $docTpl1;
$ugDoc2->status = EnUserGroupDocStatus::DELETED;
$ugDoc2->lastChangedDate = null;



if($ugdRep->Save($ugDoc2))
    echo "Документ 2 сохранен id документы $ugDoc2->id<br>";
else
    echo "Ошибка сохранения документы ".$ugdRep->GetError()."<br>";

$ugDoc1n = $ugdRep->GetById($ugDoc1->id);
if($ugDoc1n)
    echo "Копия документа 1 извлечена из базы<br>";
else 
    echo "Ошибка извлечения копии документа 1 из базы ".$ugdRep->GetError()."<br>";

$ugDoc2n = $ugdRep->GetById($ugDoc2->id);
if($ugDoc2n)
    echo "Копия документа 2 извлечена из базы<br>";
else 
    echo "Ошибка извлечения копии документа 2 из базы ".$ugdRep->GetError()."<br>";

if($ugDoc1 == $ugDoc1n)
    echo "Сравление документа 1 и копии прошло верно<br>";
else
    echo "Сравление документа 1 и копии прошло ОШИБОЧНО<br>";
if($ugDoc2 == $ugDoc2n)
    echo "Сравление документа 2 и копии прошло верно<br>";
else
    echo "Сравление документа 2 и копии прошло ОШИБОЧНО<br>";

if($ugDoc1 != $ugDoc2)
    echo "Контрольный тест прошел успешно<br>";
else
    echo "Контрольный тест прошел ОШИБОЧНО<br>";

//!!!!!!!!!!!!!!!!!!!!!!userID нужен обязательно, иначе всё валится по ключу
if($ugdRep->Delete($ugDoc1, $usr->id))
    echo "Удаление документа 1 прошло успешно<br>";
else
    echo "Удаление документа 1 прошло ОШИБОЧНО".$ugdRep->GetError()."<br>";
if($ugdRep->Delete($ugDoc2, $usr->id))
    echo "Удаление документа 2 прошло успешно<br>";
else
    echo "Удаление документа 2 прошло ОШИБОЧНО".$ugdRep->GetError()."<br>";

$dtpRep->Delete($docTpl1);
$ugrRep->Delete($ugr);
$ur->Delete($usr);


echo "</body></html>";
?>
