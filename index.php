<?php
//This account is only allowed to run SELECT queries.
$servername = "mysql.ct8.pl";
$username = "m12776_bdG64v7GR";
$password = "FgAG8WZv9n1HSdBJ30yroMirKSv4K0MXGD";
$db_name = "m12776_kompas";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db_name);
 
$xax=10;
$yax=10;
//$tabela=mysqli_select_db($conn,"compass_data");


//Check connection
//if ($conn->connect_error) {
  //die("Connection failed: " . $conn->connect_error);
//}
//echo "Connected successfully";

$pnum=0;
$ych=0;
$xch=0;

$cl=$_GET['cl'];
$an=$_GET['an'];
$gen=$_GET['gen'];

if($cl=="")$cl="a";
if($an=="")$an="ac";
if($gen=="")$gen="all";
  
if($cl=="a")$cl="%";
if($gen=="all")$gen="%";
if($an=="ac")$an="%";
  
  //echo "$cl $gen $an";
if ($an!="4")$wynik = mysqli_query($conn,"SELECT * FROM compass_data WHERE idstring NOT LIKE '4%' and idstring LIKE '".$an."_".$cl."_".$gen."'");
else $wynik = mysqli_query($conn,"SELECT * FROM compass_data WHERE idstring LIKE '".$an."_".$cl."_".$gen."'");
  //else $wynik = mysqli_query($conn,"SELECT * FROM compass_data WHERE idstring NOT LIKE '4%' and LIKE '".$an."_".$cl."_".$gen."' ");
 // $wynik=mysqli_query($conn,"select * from compass_data");
  
  
  if (mysqli_num_rows($wynik) > 0) {
     //output data of each row
   while($row = mysqli_fetch_assoc($wynik)) {
    $exres=1;
    //echo '<p> '.$row['idstring'].' '.$row['x_axis'].' '.$row['y_axis'].' '.$row['people#'].'</p>';
    
     $pnum+=$row['people#'];
     $ych+=$row['y_axis']*$row['people#'];
     $xch+=$row['x_axis']*$row['people#'];
    }
} else {
    //echo "0 results";
    if((($an=="1" or $an=="2n")and $cl=="ib") or (($an=="2l" or $an=="3" or $an=="4") and $cl=="mp"))$exres=2;
    else $exres=3;
}
    if($pnum>0){
      $xax=$xch/$pnum;
      $yax=$ych/$pnum;
    }
  
  if($cl=="%")$cl="a";
  if($gen=="%")$gen="all";
  if($an=="%")$an="ac";
?>


<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <style>
body
{
  background-color: #454545;
  align-items: center;
  text-align: center;
}
.tit
{
  font-family: 'Quicksand', sans-serif;
  font-size: 50px;
  color: #e6e6e6;
  background-color: #383838;
  position: relative;
  display: inline-block;
}
.bg
{
  margin-top: 70px;
  margin-bottom: 1em;
  display: block;
}
.comp
{
  border-radius: 4px;
}
.compass
{
  box-shadow: inset 0 0 1em #383838, 0 0 6em white;
}
.selectors
{
  margin-top: 70px;
  background-color: #383838;
  display: inline-block;
}
select
{
  margin-right: 10px;
  margin-left: 10px;
  margin-top: 7px;
  margin-bottom: 7px;
  font-size: 1.5em;
}
footer
{
  font-family: 'Monda', sans-serif;
  position: fixed;
  left: 0;
  text-align: center;
  width: 100%;
  bottom: 0;

}
.bot
{
  margin-bottom: 10px;
  text-align: center;
  background-color: #ffff4d;
}

.erp
{
    display: inline-block;
    font-family: 'Quicksand', sans-serif;
    font-size: 1.5em;
    color: #e6e6e6;
    background-color: #383838;
}
    </style>
    <meta charset="utf-8">
    <title>Trójkowy Kompas Polityczny</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Monda&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="/logolo3g.svg">
    <script>
    function valch()
    {
      a = document.getElementById("cl").value;
      b = document.getElementById("an").value;
      c = document.getElementById("gen").value;
      window.location.href = "/index.php?cl="+a+"&an="+b+"&gen="+c;
    }
    </script>
  </head>
  <body>
    <img style="height: 5vh; margin-top: 25px;" src="logolo3g.svg"><br>
    <p class="tit">Ogólnoszkolny Trójkowy Kompas Polityczny</p><br>

    <div class="selectors">
     <form action="" method="post">
      <select name="klasa" id="cl" onchange="valch()">
        <option value="a" id="a" <?php if($cl=="" or cl=="a")echo "selected=\"selected\""?> >Ze wszystkich profilów</option>
        <option value="bc" id="bc" <?php if($cl=="bc")echo "selected=\"selected\""?> >BiolChem[Mat]</option>
        <option value="mf" id="mf" <?php if($cl=="mf")echo "selected=\"selected\""?> >MatFiz</option>
        <option value="mi" id="mi" <?php if($cl=="mi")echo "selected=\"selected\""?> >MatInf</option>
        <option value="h" id="h" <?php if($cl=="h")echo "selected=\"selected\""?> >Human</option>
        <option value="mg" id="mg" <?php if($cl=="mg")echo "selected=\"selected\""?> >MatGeo</option>
        <option value="ib" id="ib" <?php if($cl=="ib")echo "selected=\"selected\""?> >IB</option>
        <option value="mp" id="mp" <?php if($cl=="mp")echo "selected=\"selected\""?> >MatPol</option>
      </select>

      <select name="Rocznik" id="an" onchange="valch()">
        <option value="ac" id="ac" <?php if($an=="ac" or an=="")echo "selected=\"selected\""?> >Z każdego rocznika</option>
        <option value="1" id="1" <?php if($an=="1")echo "selected=\"selected\""?> >1 klasa</option>
        <option value="2n" id="2n" <?php if($an=="2n")echo "selected=\"selected\""?> >2 klasa po pdst</option>
        <option value="2l" id="2l" <?php if($an=="2l")echo "selected=\"selected\""?> >2 klasa po gim</option>
        <option value="3" id="3" <?php if($an=="3")echo "selected=\"selected\""?>  >3 klasa</option>
        <option value="4" id="4" <?php if($an=="4")echo "selected=\"selected\""?> >Absolwenci</option>
      </select>

      <select name="Gender" id="gen" onchange="valch()">
        <option value="all" id="all" <?php if($gen=="all")echo "selected=\"selected\""?> >Wyniki ze wszystkich płci</option>
        <option value="c" id="c" <?php if($gen=="c")echo "selected=\"selected\""?> >Mężczyzna</option>
        <option value="d" id="d" <?php if($gen=="d")echo "selected=\"selected\""?> >Kobieta</option>
      </select>
     </form>
    </div>
    
  
    
    
    <div class="bg">
    <?php
    if($exres==1 and $pnum>0) echo "<p class=\"erp\" style=\"margin-bottom:5em;\">Liczba respondentów w tej podgrupie: ".$pnum."</p> <br> <img class=\"compass\" style=\"-webkit-user-select: none;margin: auto;\" src=\"https://www.politicalcompass.org/chart?ec=".$xax."&amp;soc=".$yax."\">";
    if($exres==1 and $pnum==0) echo "<p class=\"erp\">Nie można utworzyć kompasu ze względu na brak danych z zaznaczonej grupy 🇧🇾🇧🇾</p>";
    if($exres==3) echo "<p class=\"erp\">Bogowie informatyki się rozwścieczyli za zmienianie zmiennych</p>";
    if($exres==2) echo "<p class=\"erp\">Nie istnieje taki profil na tym roczniku</p>";
    ?>
    
    </div>

    

    <footer><p class="bot">DASZKIEWICZ • PETRULIS • MALISZEWSKI • DZIOPA • ZANTOWICZ • GŁÓWCZEWSKA</p></footer>

  </body>
</html>

<?php exit(); ?>


