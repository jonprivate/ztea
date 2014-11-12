<?php
    require_once 'db_query.php';
    connectToDB();
    
    if($_GET['query_type'] === 'topic') {
        $sql = 'SELECT topics.topic_subject, topics.topic_id, posts.post_date
        FROM topics LEFT JOIN posts ON topics.topic_id = posts.post_topic WHERE topics.topic_cat = ' . $_GET['query_id'] . ' ORDER BY posts.post_id DESC LIMIT 1';
        $result = mysql_query($sql);
        if(!$result)
        {
            $info = array("subject" => "null", "id" => "null", "date" => "null");
        }
        else
        {
            if(mysql_num_rows($result) == 0)
            {
                $info = array("subject" => "null", "id" => "null", "date" => "null");
            }
            else
            {
                $row = mysql_fetch_assoc($result);
                $info = array("subject" => $row['topic_subject'], "id" => $row['topic_id'], "date" => $row['post_date']);
            }
        }
    }
    else{
        $info = array("subject" => "null", "id" => "null", "date" => "null");
    }
    
    echo json_encode($info);
    closeDB();
    
?>