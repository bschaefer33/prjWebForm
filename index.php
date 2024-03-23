<?php
    session_start();
?>
<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
<!-- index.php - Createa a data entry page
  Class: CSC 235 Server Side Development
  Week 1: prjWebForm
  Student Name: Brittany Schaefer
  Written: 3/16/22
  Revised: 
-->
<link rel="stylesheet" href= "style.css">
<title>Week 1 Project</title>
</head>
<body>
<!--Page Header-->
<header>
    <h1>Twin Cities Amazons Roster<h1>
</header>
<!--Php code-->
<?php
//The filename of the currently executing scrip to be used
//as the action="" attribute of the form element.
$self=$_SERVER['PHP_SELF'];
//Check if it is a first time visitor
//hidSubmitFlag will not exist if this is the first time
if(array_key_exists('hidSubmitFlag',$_POST))
{
    //Look at the hidden submitFlag variable
    $submitFlag=$_POST['hidSubmitFlag'];
    //echo "DEBUG: hidSubmitFlag is: $submitFlag<br />";
    //echo "DEBUG: hidSubmitFlag is type of: ".gettype($submitFlag)."<br />";
    //get array that is stored as session variable
    $amazonRoster= unserialize(urldecode($_SESSION['serializedArray']));
    switch($submitFlag)
    {
        case"01": addRecord();
        break;

        case "99": deleteRecord();
        break;

        default: displayRoster($amazonRoster);
        //more to come
    }
}
else{
    $amazonRoster = array(
        array( 100,"Prop", "Laura", "Greenlee", 12543 ),
        array( 101,"Hooker", "Sadie", "Johnson", 12433 ),
        array( 103,"Prop", "Brittany", "Schaefer", 14938 )
    );
    //Save Array as a serialized session variable
    $_SESSION['serializedArray']= urlencode(serialize($amazonRoster));    
}
/*==========================================
        Functions are alphabetical
============================================*/

function addRecord()
{
    global $amazonRoster;
    //Add information into the array
    $amazonRoster[]= array($_POST['txtPlayerID'],
                           $_POST['txtPlayerPos'],
                           $_POST['txtFirstName'],
                           $_POST['txtLastName'],
                           $_POST['txtCippID']);
    sort($amazonRoster);
    $_SESSION['serializedArray'] = urlencode(serialize($amazonRoster));
}

function deleteRecord()
{
    global $amazonRoster;
    global $deleteMe;

    //get index from lstItem
    $deleteMe=$_POST['lstItem'];
    //Remove the selected index from array
    unset($amazonRoster[$deleteMe]);
    //save updated array
    $_SESSION['serializedArray']=urldecode(serialize($amazonRoster));
}

function displayRoster()
{
    global $amazonRoster;
    echo ("<table border='1'>");
    // display header
    echo "<tr>";
    echo "<th>Player ID</th>";
    echo "<th>Position</th>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>CIPP ID</th>";
    echo "</tr>";

    //Go through each record 
    foreach($amazonRoster as $record){
        //each row in table 
        echo("<tr>\n");
        foreach($record as $value){
            //each col in row
            echo "<td>".$value."</td>\n";
        }
        echo "</tr>\n";
    }
    echo ("</table>\n");
}

?>
<div id="mainContainer">
    <div id="leftContainer">
        <?php
        displayRoster();
        ?>
        <form action="<?php $self ?>"
            method ="POST"
            name="frmAdd">

        <fieldset id= "fieldsetAdd">
        <legend>Add a player</legend>

                <label for="txtPlayerNO">Player ID</label>
                <input type= "text" name="txtPlayerID" id="txtPlayerID" size="5" />
                <br /><br />

                <label for="txtPlayerPos">Player Position</label>
                <input type= "text" name="txtPlayerPos" id="txtPlayerPos"   />
                <br /><br />

                <label for="txtFirstName">First Name</label>
                <input type= "text" name="txtFirstName" id="txtFirstName"  />
                <br /><br />
                
                <label for="txtLastName">Last Name</label>
                <input type= "text" name="txtLastName" id="txtLastName"  />
                <br /><br />

                <label for="txtCippID">CIPP ID</label>
                <input type= "text" name="txtCippID" id="txtCippID" />
                <br /><br />
            <!--This field determines if page has been viewed already-->
            <input type='hidden' name='hidSubmitFlag' id='hidSubmitFlag' value='01' />
            <input name="btnSubmit" type="submit" value="Add this information" />
        </fieldset>
        </form>

        <form action="<?php $self ?>"
            method="POST"
            name="frmDelete">

            <fieldset id="fieldsetDelete">
            <legend>Select a player to delete</legend>
                <select name="lstItem" size="1">
                    <?php
                        //populate list box using array
                        foreach($amazonRoster as $index => $lstRecord)
                        {
                            echo "<option value='" . $index."'>"
                            .$lstRecord[0]."</option>\n";
                        }
                    ?>
                <!--<option value="100">Laura</option> 
                <option value="101">Sadie</option> 
                <option value="102">Brittany</option> -->
                </select>
                <!--This field is used to determine if the page has been viewed already
                    code 99=Delete
                -->
                <input type = 'hidden' name='hidSubmitFlag' id='hidSubmitFlag' value='99' />
                <br /><br />
                <input name= "btnSubmit" type="submit" value="Delete this selection" />
            </fieldset>
        </form>
    </div>
    <div id="rightContainer">
        <img src="graphic/graphic/IMG_E2069.jpg" alt="Rugby Picture" width=300px>
    </div>
</div>
</body>
</html>