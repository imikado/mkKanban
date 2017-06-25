<h1>#<?php echo $this->oSprint->id?> <?php echo $this->oSprint->title?></h1>
<p>Total complexity : <?php echo $this->iTotalInSprint?> </p>
<p>From <?php echo $this->oSprint->startdate?> to <?php echo $this->oSprint->enddate?> </p>
<p>Nb jour ouvre: <?php echo $this->nbJourOuvreSprint?></p>
<?php

$oStartdate=new Datetime($this->oSprint->startdate);
$sStart=$oStartdate->format('Y-m-d');

$sStartzone=$oStartdate->sub(new DateInterval('P1D'))->format('Y-m-d');

$oEnddate=new Datetime($this->oSprint->enddate);
$sEnd=$oEnddate->format('Y-m-d');

$sEndzone=$oEnddate->add(new DateInterval('P1D'))->format('Y-m-d');



$oChartLine=new plugin_chart('LINEBYDATE',720,180);
   $oChartLine->setTextSizeLegend('12px arial');
   $oChartLine->setMarginLeft(20);
   $oChartLine->setPaddingX(0);
   $oChartLine->setPaddingY(0);
   
   $oChartLine->setStartdate($sStartzone);
   $oChartLine->setEnddate($sEndzone);
  
   //coordonnees de la legende
   $oChartLine->setCoordLegend(520,10);
  
   $oChartLine->setStepX(2);
   $oChartLine->setStepY(1);
  
   //$oChartLine->addMarkerY(100,'#444');
   //$oChartLine->setGridY(2,'#444');
   
   $oChartLine->addGroup('Sprint','green');
       $oChartLine->addPoint($sStart,$this->iTotalInSprint);
       $oChartLine->addPoint($sEnd,0);
       
  
       
     /* 
   $oChartLine->addGroup('bois','blue');
       $oChartLine->addPoint(2010,80);
       $oChartLine->addPoint(2011,20);
       $oChartLine->addPoint(2013,170);
  */
   echo $oChartLine->show();
   
   ?>
 <h2> Prevision:  </h2>
 <p>date de fin estim&eacute;e: <?php echo $this->oLastDate->format('d/m/Y')?></p>
 <p>Solde complexity: <?php echo $this->iTotalOutSprint?></p>
 <p>Nb jour ouvre: <?php echo $this->nbDayJouvrePrev?></p>
 <?php
 
 $oEndzone=clone $this->oLastDate;
 $oEndzone->add(new DateInterval('P1D'));
 $sEndzone=$oEndzone->format('Y-m-d');

   
   $oChartLine2=new plugin_chart('LINEBYDATE',1290,340);
   $oChartLine2->setTextSizeLegend('12px arial');
   $oChartLine2->setMarginLeft(20);
   $oChartLine2->setPaddingX(0);
   $oChartLine2->setPaddingY(0);
   
   $oChartLine2->setStartdate($sStartzone);
   $oChartLine2->setEnddate($sEndzone);
  
   //coordonnees de la legende
   $oChartLine2->setCoordLegend(920,10);
  
   $oChartLine2->setStepX(2);
   $oChartLine2->setStepY(1);
  
   //$oChartLine->addMarkerY(100,'#444');
   //$oChartLine->setGridY(2,'#444');
   
   $oChartLine2->addGroup('Sprint','green');
       $oChartLine2->addPoint($sStart,$this->iTotalInSprint);
       $oChartLine2->addPoint($sEnd,0);
       
    $oChartLine2->addGroup('Solde','red');
       $oChartLine2->addPoint($sEnd,$this->iTotalOutSprint);
       $oChartLine2->addPoint($this->oLastDate->format('Y-m-d'),0);
       
     /* 
   $oChartLine->addGroup('bois','blue');
       $oChartLine->addPoint(2010,80);
       $oChartLine->addPoint(2011,20);
       $oChartLine->addPoint(2013,170);
  */
   echo $oChartLine2->show();
   
   ?>