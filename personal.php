<?php
    include 'header.php';
    require_once 'db_query.php';
    connectToDB();
    
    if(!$uid_isset || !$uid_isvalid)
    {
        //the user is not signed in
        echo '<a href="/ztea/login.php">Sign in</a> to view more.';
    }
    else
    {
        echo '<p>Coupons!</p>';
        echo '<a href="/ztea/create_mix.php">Create your own mix!</a>';
        echo '<p>List of all your mixes</p>';
        $sql = "SELECT mix_id, mix_name, mix_description FROM mixes";
        $result = mysql_query($sql);
        if(!$result)
        {
            echo 'The mixes could not be displayed, please try again later.';
        }
        else
        {
            if(mysql_num_rows($result) == 0)
            {
                echo 'No mixes created yet.';
            }
            else
            {
                //prepare the table
                echo '<table border="1">
                <tr>
                <th>Mixes</th>
                <th>Description</th>
                </tr>';
                
                $rows = array();
                while($row = mysql_fetch_assoc($result))
                {
                    echo '<tr>';
                    echo '<td class="leftpart">';
                    echo '<h3><a href="mixes.php?id=' . $row['mix_id'] . '">' . $row['mix_name'] . '</a></h3>';
                    echo '</td>';
                    echo '<td class="rightpart">';
                    echo $row['mix_description'];
                    echo '</td>';
                    echo '</tr>';
                    $rows[] = $row['mix_id'];
                }
                echo '</table>';
            }
        }
    }
    
    include 'footer.php';
    closeDB();
?>