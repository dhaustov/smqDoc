<?php

require_once 'Init.php';
/*
 * Test file for P. Serdukov
 * 
 */
echo "Create Rep <br>";
/* @var $dtpRep DocTemplateRepository */
$dtpRep = new DocTemplateRepository;
echo 'Create 1 DT<br>';
/* @var $docTpl1 DocTemplate */
$docTpl1 = new DocTemplate;
$docTpl1->name = "ываываы ыв аыв а";
$docTpl1->lstobjFields = array();
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
$docTpl1->lstobjFields[$docTpl1F1->id] = $docTpl1F1;
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
$docTpl1->lstobjFields[$docTpl1F2->id] = $docTpl1F2;
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
$docTpl1->lstobjFields[$docTpl1F3->id] = $docTpl1F3;

$dtpRep->Save($docTpl1);
echo 'Create 2 DT<br>';
/* @var $docTpl2 DocTemplate */
$docTpl2 = new DocTemplate;
$docTpl2->name = "First doc tpl";
$docTpl2->lstobjFields = array();
echo 'Create  DT f1<br>';
/*@var $docTpl2F1 DocTemplateField*/
$docTpl2F1 = new DocTemplateField;
$docTpl2F1->id  = -3;
$docTpl2F1->name = "dt2f1";
$docTpl2F1->isCalculated = false;
$docTpl2F1->fieldType = $dtpRep->docTemplateFieldTypesArr[1];
$docTpl2F1->operation = $dtpRep->docTemplateOperationsArr[1];
$docTpl2F1->isRestricted = false;
$docTpl2F1->minVal  = 10;
$docTpl2F1->maxVal = 20;
$docTpl2->lstobjFields[$docTpl2F1->id] = $docTpl2F1;
echo 'Create  DT f2<br>';
/*@var $docTpl2F2 DocTemplateField*/
$docTpl2F2 = new DocTemplateField;
$docTpl2F2->id  = -2;
$docTpl2F2->name = "dt2f2";
$docTpl2F2->isCalculated = true;
$docTpl2F2->fieldType = $dtpRep->docTemplateFieldTypesArr[2];
$docTpl2F2->operation = $dtpRep->docTemplateOperationsArr[1];
$docTpl2F2->isRestricted = true;
$docTpl2F2->minVal  = 15;
$docTpl2F2->maxVal = 70;
$docTpl2->lstobjFields[$docTpl2F2->id] = $docTpl2F2;
echo 'Create  DT f3<br>';
/*@var $docTpl2F3 DocTemplateField*/
$docTpl2F3 = new DocTemplateField;
$docTpl2F3->id  = -1;
$docTpl2F3->name = "dt2f3";
$docTpl2F3->isCalculated = true;
$docTpl2F3->fieldType = $dtpRep->docTemplateFieldTypesArr[2];
$docTpl2F3->operation = $dtpRep->docTemplateOperationsArr[1];
$docTpl2F3->isRestricted = true;
$docTpl2F3->minVal  = 10;
$docTpl2F3->maxVal = 200;
$docTpl2->lstobjFields[$docTpl2F3->id] = $docTpl2F3;

if(!$dtpRep->Save($docTpl2))

echo "Get 1 DT from DB<br>";
/* @var $docTpl1N DocTemplate */
$docTpl1N = $dtpRep->GetByID($docTpl1->id);
echo "Get 2 DT from DB<br>";
/* @var $docTpl2N DocTemplate */
$docTpl2N = $dtpRep->GetByID($docTpl2->id);

if($docTpl1 == $docTpl1N)
{
    echo "docTp1 CURRECT <br>";
}
else
{
    echo "docTp1 WRONG <br>";
    print_r($docTpl1);
    echo "<br>";
    print_r($docTpl1N);
}
if($docTpl2 == $docTpl2N )
{
    echo "docTp2 CURRECT<br>";
}
else
{
    echo "docTp2 WRONG <br>";
    print_r($docTpl2);
    echo "<br>";
    print_r($docTpl2N);
}

if($docTpl1 == $docTpl2 )
{
    echo "TEST FALSE <br>";
}
else
{
    echo "TEST TRUE <br>";
}

?>
