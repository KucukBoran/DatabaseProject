<?php
    $serverName = "DESKTOP-MT912UL\SQLEXPRESS";
    $connectionOptions = array(
    "Database" => "DatabaseProject",
    "Uid" => "", 
    "PWD" => ""  

);
    $authorName = $_POST["author_name"];
    $authorSurname = $_POST["author_surname"];
    $authorEmail = $_POST["author_email"];
    $thesisNo = $_POST["thesis_no"];
    $thesisTitle = $_POST["thesis_title"];
    $thesisAbstract = $_POST["thesis_abstract"];
    $thesisYear = $_POST["thesis_year"];
    $thesisType = $_POST["thesis_type"];  
    $universityName = $_POST["university_name"];
    $instituteName = $_POST["institute_name"];
    $numberofPages = $_POST["number_of_pages"];
    $languageName = $_POST["language_name"];
    $submissionDate = $_POST["submission_date"];
    $cosupervisorName = $_POST["cosupervisor_name"];  
    $cosupervisorlastName = $_POST["cosupervisor_lastname"];
    $supervisorName = $_POST["supervisor_name"];
    $supervisorlastName = $_POST["supervisor_lastname"];
    $keyword = $_POST["keyword"];
    $keywordArray = explode(" ", $keyword);
    $topics = $_POST["topics"];
    


    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn) {

    $sqlCheckAuthor = "SELECT AUTHOR_ID FROM AUTHOR WHERE AUTHOR_NAME = ? AND AUTHOR_LASTNAME = ? AND AUTHOR_EMAIL = ?";
    $paramsCheckAuthor = array($authorName, $authorSurname, $authorEmail);
    $stmtCheckAuthor = sqlsrv_query($conn, $sqlCheckAuthor, $paramsCheckAuthor);

// Yazar var mý yok mu kontrol et
    if ($stmtCheckAuthor !== false) {
    if (sqlsrv_has_rows($stmtCheckAuthor)) {
        $row = sqlsrv_fetch_array($stmtCheckAuthor, SQLSRV_FETCH_ASSOC);
        $authorId = $row['AUTHOR_ID'];
    } else {
        // Yazar yoksa, yeni bir yazar ekleyin
        $sqlInsertAuthor = "INSERT INTO AUTHOR (AUTHOR_NAME, AUTHOR_LASTNAME, AUTHOR_EMAIL) VALUES (?, ?, ?)";
        $paramsInsertAuthor = array($authorName, $authorSurname, $authorEmail);
        $stmtInsertAuthor = sqlsrv_query($conn, $sqlInsertAuthor, $paramsInsertAuthor);

        // Eklenen yazarýn ID'sini al
         
    }
} else {
    // Hata durumu
    die(print_r(sqlsrv_errors(), true));
}

        $sqlCheckAuthor = "SELECT AUTHOR_ID FROM AUTHOR WHERE AUTHOR_NAME = ? AND AUTHOR_LASTNAME = ? AND AUTHOR_EMAIL = ?";
        $paramsCheckAuthor = array($authorName, $authorSurname, $authorEmail);
        $stmtCheckAuthor = sqlsrv_query($conn, $sqlCheckAuthor, $paramsCheckAuthor);

        if ($stmtCheckAuthor && sqlsrv_has_rows($stmtCheckAuthor)) {
        $row = sqlsrv_fetch_array($stmtCheckAuthor, SQLSRV_FETCH_ASSOC);
        $authorId = $row['AUTHOR_ID'];
    }

    $sqlFindUniversity = "SELECT UNIVERSITY_ID FROM UNIVERSITY WHERE UNIVERSITY_NAME = ?";
    $paramsFindUniversity = array($universityName);
    $stmtFindUniversity = sqlsrv_query($conn, $sqlFindUniversity, $paramsFindUniversity);

    if ($stmtFindUniversity && sqlsrv_has_rows($stmtFindUniversity)) {
        $row = sqlsrv_fetch_array($stmtFindUniversity, SQLSRV_FETCH_ASSOC);
        $universityId = $row['UNIVERSITY_ID'];
    }
    else{
        echo "Invalid University Name";
        exit;
    }
        
        $sqlFindInstitute = "SELECT INSTITUTE_ID FROM INSTITUTE WHERE INSTITUTE_NAME = ?";
        $paramsFindInstitute = array($instituteName);
        $stmtFindInstitute = sqlsrv_query($conn, $sqlFindInstitute, $paramsFindInstitute);

        if ($stmtFindInstitute && sqlsrv_has_rows($stmtFindInstitute)) {
            $row = sqlsrv_fetch_array($stmtFindInstitute, SQLSRV_FETCH_ASSOC);
            $instituteId = $row['INSTITUTE_ID'];
        }
        else {
        echo "Invalid Institute Name";
        exit;
        }
            
            $sqlFindAuthor = "SELECT AUTHOR_ID FROM AUTHOR WHERE AUTHOR_NAME = ?";
            $paramsFindAuthor = array($authorName);
            $stmtFindAuthor = sqlsrv_query($conn, $sqlFindAuthor, $paramsFindAuthor);

            if ($stmtFindAuthor && sqlsrv_has_rows($stmtFindAuthor)) {
                $row = sqlsrv_fetch_array($stmtFindAuthor, SQLSRV_FETCH_ASSOC);
                $authorId = $row['AUTHOR_ID'];
            }
                
                $sqlFindCosupervisor = "SELECT COSUPERVISOR_ID FROM COSUPERVISOR WHERE COSUPERVISOR_NAME = ? AND COSUPERVISOR_LASTNAME = ?";
                $paramsFindCosupervisor = array($cosupervisorName, $cosupervisorlastName);
                $stmtFindCosupervisor = sqlsrv_query($conn, $sqlFindCosupervisor, $paramsFindCosupervisor);
                if ($stmtFindCosupervisor && sqlsrv_has_rows($stmtFindCosupervisor)) {
                    $row = sqlsrv_fetch_array($stmtFindCosupervisor, SQLSRV_FETCH_ASSOC);
                    $cosupervisorId = $row['COSUPERVISOR_ID'];
                }
                else{
                    $cosupervisorId = null;
                }
                    // Language tablosundan language_id'yi ara
                    $sqlFindLanguage = "SELECT LANGUAGE_ID FROM LANGUAGE WHERE LANGUAGE_NAME = ?";
                    $paramsFindLanguage = array($languageName);
                    $stmtFindLanguage = sqlsrv_query($conn, $sqlFindLanguage, $paramsFindLanguage);

                    if ($stmtFindLanguage && sqlsrv_has_rows($stmtFindLanguage)) {
                        $row = sqlsrv_fetch_array($stmtFindLanguage, SQLSRV_FETCH_ASSOC);
                        $languageId = $row['LANGUAGE_ID'];

                    } 
                    else{
                        echo "Invalid Language Name";
                        exit;
                    }

                    

                    



    
    $sqlInsertThesis = "INSERT INTO THESIS (THESIS_NO, THESIS_TITLE, THESIS_ABSTRACT, AUTHOR_ID, THESIS_YEAR, THESIS_TYPE, UNIVERSITY_ID, INSTITUTE_ID, NUMBER_OF_PAGES, LANGUAGE_ID, SUBMISSION_DATE, COSUPERVISOR_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $paramsInsertThesis = array($thesisNo, $thesisTitle, $thesisAbstract, $authorId, $thesisYear, $thesisType, $universityId, $instituteId, $numberofPages, $languageId, $submissionDate, $cosupervisorId);
    $stmtInsertThesis = sqlsrv_query($conn, $sqlInsertThesis, $paramsInsertThesis);


        $sqlFindthesisId = "SELECT THESIS_ID FROM THESIS WHERE THESIS_NO = ?";
        $paramsFindthesisId = array($thesisNo);
        $stmtFindthesisId = sqlsrv_query($conn, $sqlFindthesisId, $paramsFindthesisId);

        if ($stmtFindthesisId && sqlsrv_has_rows($stmtFindthesisId)) {
        $row = sqlsrv_fetch_array($stmtFindthesisId, SQLSRV_FETCH_ASSOC);
        $thesisId = $row['THESIS_ID'];
        } 
        
       foreach ($keywordArray as $keyword) {
        if (!empty($keyword)) {
        $sqlCheckKeyword = "SELECT KEYWORDS_ID FROM KEYWORDS WHERE KEYWORD = ?";
        $paramsCheckKeyword = array($keyword);
        $stmtCheckKeyword = sqlsrv_query($conn, $sqlCheckKeyword, $paramsCheckKeyword);

        if ($stmtCheckKeyword) {
            if (sqlsrv_has_rows($stmtCheckKeyword)) {
                $row = sqlsrv_fetch_array($stmtCheckKeyword, SQLSRV_FETCH_ASSOC);
                $keywordId = $row['KEYWORDS_ID'];
            } else {
                $sqlInsertKeyword = "INSERT INTO KEYWORDS (KEYWORD) VALUES (?)";
                $paramsInsertKeyword = array($keyword);
                $stmtInsertKeyword = sqlsrv_query($conn, $sqlInsertKeyword, $paramsInsertKeyword);

                // Eklenen keyword'un ID'sini al
                $sqlCheckKeywordId = "SELECT KEYWORDS_ID FROM KEYWORDS WHERE KEYWORD = ?";
                $paramsCheckKeywordId = array($keyword);
                $stmtCheckKeywordId = sqlsrv_query($conn, $sqlCheckKeywordId, $paramsCheckKeywordId);
                if (sqlsrv_has_rows($stmtCheckKeywordId)) {
                $row = sqlsrv_fetch_array($stmtCheckKeywordId, SQLSRV_FETCH_ASSOC);
                $keywordId = $row['KEYWORDS_ID'];
            }

                
            }

            // KEYWORD_THESIS tablosuna ekle
            $sqlInsertKeywordThesis = "INSERT INTO KEYWORD_THESIS (THESIS_ID, KEYWORDS_ID) VALUES (?, ?)";
            $paramsInsertKeywordThesis = array($thesisId, $keywordId);
            $stmtInsertKeywordThesis = sqlsrv_query($conn, $sqlInsertKeywordThesis, $paramsInsertKeywordThesis);
        }
    }
}    
        // Konuyu bul
        $sqlFindTopicId = "SELECT TOPICS_ID FROM TOPICS WHERE TOPICS_NAME = ?";
        $paramsFindTopicId = array($topics);
        $stmtFindTopicId = sqlsrv_query($conn, $sqlFindTopicId, $paramsFindTopicId);

        if ($stmtFindTopicId && sqlsrv_has_rows($stmtFindTopicId)) {
            $row = sqlsrv_fetch_array($stmtFindTopicId, SQLSRV_FETCH_ASSOC);
            $topicId = $row['TOPICS_ID'];
        }
        
        // THESIS_TOPICS tablosuna ekle
        $sqlInsertThesisTopic = "INSERT INTO THESIS_TOPICS (TOPICS_ID, THESIS_ID) VALUES (?, ?)";
        $paramsInsertThesisTopic = array($topicId, $thesisId);
        $stmtInsertThesisTopic = sqlsrv_query($conn, $sqlInsertThesisTopic, $paramsInsertThesisTopic);

        if($stmtInsertThesisTopic){

        }
        else{
            echo "Invalid Topic Name";
            exit;
        }
     
        $sqlFindSupervisor = "SELECT SUPERVISOR_ID FROM SUPERVISOR WHERE SUPERVISOR_NAME = ? AND SUPERVISOR_LASTNAME = ?";
        $paramsFindSupervisor = array($supervisorName,$supervisorlastName);
        $stmtFindSupervisor = sqlsrv_query($conn, $sqlFindSupervisor, $paramsFindSupervisor);

        if ($stmtFindSupervisor && sqlsrv_has_rows($stmtFindSupervisor)) {
        $row = sqlsrv_fetch_array($stmtFindSupervisor, SQLSRV_FETCH_ASSOC);
        $supervisorId = $row['SUPERVISOR_ID'];
        }   

        $sqlInsertsupervisorThesis = "INSERT INTO SUPERVISOR_THESIS (SUPERVISOR_ID, THESIS_ID) VALUES (?, ?)";
        $paramsInsertsupervisorThesis = array($supervisorId, $thesisId);
        $stmtInsertsupervisorThesis = sqlsrv_query($conn, $sqlInsertsupervisorThesis, $paramsInsertsupervisorThesis);

        if ($stmtInsertThesis) {
            echo "Success";
        } else {
            echo "Failed";
        }
        sqlsrv_close($conn);
    } else {
        echo "Database Connection Error";
    }

?>
