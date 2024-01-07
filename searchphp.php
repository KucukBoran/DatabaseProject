<?php
$serverName = "DESKTOP-MT912UL\SQLEXPRESS";
$connectionOptions = array(
    "Database" => "DatabaseProject",
    "Uid" => "",
    "PWD" => ""
);

$searchTerm = $_POST["searchTerm"];
$searchField = $_POST["searchField"];
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn) {
       if ($searchField === "THESIS_TITLE" || $searchField === "THESIS_NO" || $searchField === "THESIS_ABSTRACT" || $searchField === "THESIS_YEAR" || $searchField === "THESIS_TYPE" || $searchField === "NUMBER_OF_PAGES" || $searchField === "SUBMISSION_DATE") {
        $sqlFindThesis = "SELECT THESIS_ID, THESIS_NO, THESIS_TITLE, THESIS_ABSTRACT, AUTHOR_ID, THESIS_YEAR, THESIS_TYPE, UNIVERSITY_ID, INSTITUTE_ID, NUMBER_OF_PAGES, LANGUAGE_ID, SUBMISSION_DATE, COSUPERVISOR_ID FROM THESIS WHERE $searchField = ?";
        $paramsFindThesis = array($searchTerm);
        $stmtFindThesis = sqlsrv_query($conn, $sqlFindThesis, $paramsFindThesis);

        if ($stmtFindThesis) {
            
            echo "<table border='1'>";
            echo "<tr><th>Thesis ID</th><th>Thesis No</th><th>Thesis Title</th><th>Thesis Abstract</th><th>Thesis Year</th><th>Thesis Type</th><th>Submission Date</th><th>University</th><th>Institute</th><th>Number of Pages</th><th>Language</th><th>Cosupervisor</th><th>Author</th><th>Supervisor</th><th>Keywords</th><th>Topics</th></tr>";
            while ($row = sqlsrv_fetch_array($stmtFindThesis, SQLSRV_FETCH_ASSOC)) {
                $thesisId = $row['THESIS_ID'];
                $thesisNo = $row['THESIS_NO'];
                $thesisTitle = $row['THESIS_TITLE'];
                $thesisAbstract = $row['THESIS_ABSTRACT'];
                $authorId = $row['AUTHOR_ID'];
                $thesisYear = $row['THESIS_YEAR'];
                $thesisType = $row['THESIS_TYPE'];
                $universityId = $row['UNIVERSITY_ID'];
                $instituteId = $row['INSTITUTE_ID'];
                $numberofPages = $row['NUMBER_OF_PAGES'];
                $languageId = $row['LANGUAGE_ID'];
                $submissionDate = $row['SUBMISSION_DATE'];
                $cosupervisorId = $row['COSUPERVISOR_ID'];

                echo "<tr><td>$thesisId</td><td>$thesisNo</td><td>$thesisTitle</td><td>$thesisAbstract</td><td>$thesisYear</td><td>$thesisType</td><td>" . $submissionDate->format('Y-m-d') . "</td><td>";

                // University Name
                $sqlFindUniversity = "SELECT UNIVERSITY_NAME FROM UNIVERSITY WHERE UNIVERSITY_ID = ?";
                $paramsFindUniversity = array($universityId);
                $stmtFindUniversity = sqlsrv_query($conn, $sqlFindUniversity, $paramsFindUniversity);

                if ($stmtFindUniversity && sqlsrv_has_rows($stmtFindUniversity)) {
                    $row = sqlsrv_fetch_array($stmtFindUniversity, SQLSRV_FETCH_ASSOC);
                    $universityName = $row['UNIVERSITY_NAME'];
                    echo $universityName;
                }

                echo "</td><td>";

                // Institute Name
                $sqlFindInstitute = "SELECT INSTITUTE_NAME FROM INSTITUTE WHERE INSTITUTE_ID = ?";
                $paramsFindInstitute = array($instituteId);
                $stmtFindInstitute = sqlsrv_query($conn, $sqlFindInstitute, $paramsFindInstitute);

                if ($stmtFindInstitute && sqlsrv_has_rows($stmtFindInstitute)) {
                    $row = sqlsrv_fetch_array($stmtFindInstitute, SQLSRV_FETCH_ASSOC);
                    $instituteName = $row['INSTITUTE_NAME'];
                    echo $instituteName;
                }

                echo "</td><td>$numberofPages</td><td>";

                // Language Name
                $sqlFindLanguage = "SELECT LANGUAGE_NAME FROM LANGUAGE WHERE LANGUAGE_ID = ?";
                $paramsFindLanguage = array($languageId);
                $stmtFindLanguage = sqlsrv_query($conn, $sqlFindLanguage, $paramsFindLanguage);

                if ($stmtFindLanguage && sqlsrv_has_rows($stmtFindLanguage)) {
                    $row = sqlsrv_fetch_array($stmtFindLanguage, SQLSRV_FETCH_ASSOC);
                    $languageName = $row['LANGUAGE_NAME'];
                    echo $languageName;
                }

                echo "</td><td>";

                // Cosupervisor Name
                $sqlFindCosupervisor = "SELECT COSUPERVISOR_NAME,COSUPERVISOR_LASTNAME FROM COSUPERVISOR WHERE COSUPERVISOR_ID = ?";
                $paramsFindCosupervisor = array($cosupervisorId);
                $stmtFindCosupervisor = sqlsrv_query($conn, $sqlFindCosupervisor, $paramsFindCosupervisor);

                if ($stmtFindCosupervisor && sqlsrv_has_rows($stmtFindCosupervisor)) {
                    $row = sqlsrv_fetch_array($stmtFindCosupervisor, SQLSRV_FETCH_ASSOC);
                    $cosupervisorName = $row['COSUPERVISOR_NAME'];
                    $cosupervisorlastName = $row['COSUPERVISOR_LASTNAME'];
                    echo $cosupervisorName . ' ' . $cosupervisorlastName;
                }

                echo "</td><td>";


                $sqlFindAuthor = "SELECT AUTHOR_NAME, AUTHOR_LASTNAME FROM AUTHOR WHERE AUTHOR_ID = ?";
                $paramsFindAuthor = array($authorId);
                $stmtFindAuthor = sqlsrv_query($conn, $sqlFindAuthor, $paramsFindAuthor);

                if ($stmtFindAuthor && sqlsrv_has_rows($stmtFindAuthor)) {
                    $row = sqlsrv_fetch_array($stmtFindAuthor, SQLSRV_FETCH_ASSOC);
                    $authorName = $row['AUTHOR_NAME'];
                    $authorlastName = $row['AUTHOR_LASTNAME'];
                    echo $authorName . ' ' . $authorlastName;

                }
                                
                echo "</td><td>";

                $sqlFindSupervisorId = "SELECT SUPERVISOR_ID FROM SUPERVISOR_THESIS WHERE THESIS_ID = ?";
                $paramsFindSupervisorId = array($thesisId);
                $stmtFindSupervisorId = sqlsrv_query($conn, $sqlFindSupervisorId, $paramsFindSupervisorId);

                if ($stmtFindSupervisorId && sqlsrv_has_rows($stmtFindSupervisorId)) {
                    $row = sqlsrv_fetch_array($stmtFindSupervisorId, SQLSRV_FETCH_ASSOC);
                    $supervisorId = $row['SUPERVISOR_ID'];                   
                }

                $sqlFindSupervisor = "SELECT SUPERVISOR_NAME,SUPERVISOR_LASTNAME FROM SUPERVISOR WHERE SUPERVISOR_ID = ?";
                $paramsFindSupervisor = array($supervisorId);
                $stmtFindSupervisor = sqlsrv_query($conn, $sqlFindSupervisor, $paramsFindSupervisor);

                if ($stmtFindSupervisor && sqlsrv_has_rows($stmtFindSupervisor)) {
                    $row = sqlsrv_fetch_array($stmtFindSupervisor, SQLSRV_FETCH_ASSOC);
                    $supervisorName = $row['SUPERVISOR_NAME'];
                    $supervisorlastName = $row['SUPERVISOR_LASTNAME'];
                    echo $supervisorName . ' ' . $supervisorlastName;
                }

                echo "</td><td>";

                $sqlFindKeywordsId = "SELECT KEYWORDS_ID FROM KEYWORD_THESIS WHERE THESIS_ID = ?";
                $paramsFindKeywordsId = array($thesisId);
                $stmtFindKeywordsId = sqlsrv_query($conn, $sqlFindKeywordsId, $paramsFindKeywordsId);

                $keywords = array(); // Keyword'leri saklamak için boþ bir dizi oluþturuyoruz.

                if ($stmtFindKeywordsId && sqlsrv_has_rows($stmtFindKeywordsId)) {
                    while ($row = sqlsrv_fetch_array($stmtFindKeywordsId, SQLSRV_FETCH_ASSOC)) {
                        $keywords[] = $row['KEYWORDS_ID']; // Keyword ID'yi diziye ekliyoruz.
                    }
                }



                // Her bir keyword için ayrý bir sorgu yaparak sonuçlarý ekrana yazýyoruz.
                foreach ($keywords as $keywordId) {
                    $sqlFindKeywords = "SELECT KEYWORD FROM KEYWORDS WHERE KEYWORDS_ID = ?";
                    $paramsFindKeywords = array($keywordId);
                    $stmtFindKeywords = sqlsrv_query($conn, $sqlFindKeywords, $paramsFindKeywords);

                    if ($stmtFindKeywords && sqlsrv_has_rows($stmtFindKeywords)) {
                        $row = sqlsrv_fetch_array($stmtFindKeywords, SQLSRV_FETCH_ASSOC);
                        $keyword = $row['KEYWORD'];
                        echo $keyword . "<br>"; // Her bir keyword'i yeni bir satýrda gösteriyoruz.
                    }
                }


                echo "</td><td>";


                $sqlFindTopicsId = "SELECT TOPICS_ID FROM THESIS_TOPICS WHERE THESIS_ID = ?";
                $paramsFindTopicsId = array($thesisId);
                $stmtFindTopicsId = sqlsrv_query($conn, $sqlFindTopicsId, $paramsFindTopicsId);

                if ($stmtFindTopicsId && sqlsrv_has_rows($stmtFindTopicsId)) {
                    $row = sqlsrv_fetch_array($stmtFindTopicsId, SQLSRV_FETCH_ASSOC);
                    $TopicsId = $row['TOPICS_ID'];                   
                }

                $sqlFindTopics = "SELECT TOPICS_NAME FROM TOPICS WHERE TOPICS_ID = ?";
                $paramsFindTopics = array($TopicsId);
                $stmtFindTopics = sqlsrv_query($conn, $sqlFindTopics, $paramsFindTopics);

                if ($stmtFindTopics && sqlsrv_has_rows($stmtFindTopics)) {
                    $row = sqlsrv_fetch_array($stmtFindTopics, SQLSRV_FETCH_ASSOC);
                    $Topics = $row['TOPICS_NAME'];
                    
                    echo $Topics;
                }

                echo "</td><tr>";
            }

            echo "</table>";

        } else {
            echo "Sorgu hatasý: " . print_r(sqlsrv_errors(), true);
        }
    } 
    
   
    
    
    else if ($searchField === "COSUPERVISOR_NAME") {
    // Kullanýcýdan alýnan isim-soyisim deðerini boþluk karakterine göre ayýrma
    $cosupervisorFullName = $searchTerm;
    $cosupervisorNameParts = explode(' ', $cosupervisorFullName);

    if (count($cosupervisorNameParts) > 1) {
        $cosupervisorName = $cosupervisorNameParts[0];
        $cosupervisorLastName = $cosupervisorNameParts[1];
    } else {
        $cosupervisorName = $cosupervisorFullName;
        $cosupervisorLastName = null; // Eðer sadece isim verilmiþse soyisimi kontrol etme
    }

    // Supervisor Name ve Supervisor Lastname deðerlerini kontrol etmek üzere sorgu oluþturma
    if ($cosupervisorLastName !== null) {
        // Eðer soyisim varsa hem isim hem soyisim üzerinden sorgu yap
        $sqlFindcoSupervisorId = "SELECT COSUPERVISOR_ID FROM COSUPERVISOR WHERE COSUPERVISOR_NAME = ? AND COSUPERVISOR_LASTNAME = ?";
        $paramsFindcoSupervisorId = array($cosupervisorName, $cosupervisorLastName);
    } else {
        // Eðer sadece isim varsa sadece isim üzerinden sorgu yap
        $sqlFindcoSupervisorId = "SELECT COSUPERVISOR_ID FROM COSUPERVISOR WHERE COSUPERVISOR_NAME = ?";
        $paramsFindcoSupervisorId = array($cosupervisorName);
    }

    $stmtFindcoSupervisorId = sqlsrv_query($conn, $sqlFindcoSupervisorId, $paramsFindcoSupervisorId);

    if ($stmtFindcoSupervisorId) {
        echo "<table border='1'>";
        echo "<tr><th>Thesis ID</th><th>Thesis No</th><th>Thesis Title</th><th>Thesis Abstract</th><th>Thesis Year</th><th>Thesis Type</th><th>Submission Date</th><th>University</th><th>Institute</th><th>Number of Pages</th><th>Language</th><th>Cosupervisor</th><th>Author</th><th>Supervisor</th><th>Keywords</th><th>Topics</th></tr>";
        while ($row = sqlsrv_fetch_array($stmtFindcoSupervisorId, SQLSRV_FETCH_ASSOC)) {
            $cosupervisorId = $row['COSUPERVISOR_ID'];

            
            $sqlFindcosupervisorThesis = "SELECT THESIS_ID FROM THESIS WHERE COSUPERVISOR_ID = ?";
            $paramsFindcosupervisorThesis = array($cosupervisorId);
            $stmtFindcosupervisorThesis = sqlsrv_query($conn, $sqlFindcosupervisorThesis, $paramsFindcosupervisorThesis);

            while ($rowThesis = sqlsrv_fetch_array($stmtFindcosupervisorThesis, SQLSRV_FETCH_ASSOC)) {
                $thesisId = $rowThesis['THESIS_ID'];

               
                $sqlFindThesis = "SELECT THESIS_ID, THESIS_NO, THESIS_TITLE, THESIS_ABSTRACT, AUTHOR_ID, THESIS_YEAR, THESIS_TYPE, UNIVERSITY_ID, INSTITUTE_ID, NUMBER_OF_PAGES, LANGUAGE_ID, SUBMISSION_DATE, COSUPERVISOR_ID FROM THESIS WHERE THESIS_ID = ?";
                $paramsFindThesis = array($thesisId);
                $stmtFindThesis = sqlsrv_query($conn, $sqlFindThesis, $paramsFindThesis);

                while ($rowThesisDetails = sqlsrv_fetch_array($stmtFindThesis, SQLSRV_FETCH_ASSOC)) {
                    $thesisId = $rowThesisDetails['THESIS_ID'];
                    $thesisNo = $rowThesisDetails['THESIS_NO'];
                    $thesisTitle = $rowThesisDetails['THESIS_TITLE'];
                    $thesisAbstract = $rowThesisDetails['THESIS_ABSTRACT'];
                    $authorId = $rowThesisDetails['AUTHOR_ID'];
                    $thesisYear = $rowThesisDetails['THESIS_YEAR'];
                    $thesisType = $rowThesisDetails['THESIS_TYPE'];
                    $universityId = $rowThesisDetails['UNIVERSITY_ID'];
                    $instituteId = $rowThesisDetails['INSTITUTE_ID'];
                    $numberofPages = $rowThesisDetails['NUMBER_OF_PAGES'];
                    $languageId = $rowThesisDetails['LANGUAGE_ID'];
                    $submissionDate = $rowThesisDetails['SUBMISSION_DATE'];
                    $cosupervisorId = $rowThesisDetails['COSUPERVISOR_ID'];

                    echo "<tr><td>$thesisId</td><td>$thesisNo</td><td>$thesisTitle</td><td>$thesisAbstract</td><td>$thesisYear</td><td>$thesisType</td><td>" . $submissionDate->format('Y-m-d') . "</td><td>";

                    
                    $sqlFindUniversity = "SELECT UNIVERSITY_NAME FROM UNIVERSITY WHERE UNIVERSITY_ID = ?";
                    $paramsFindUniversity = array($universityId);
                    $stmtFindUniversity = sqlsrv_query($conn, $sqlFindUniversity, $paramsFindUniversity);

                    if ($stmtFindUniversity && sqlsrv_has_rows($stmtFindUniversity)) {
                        $rowUniversity = sqlsrv_fetch_array($stmtFindUniversity, SQLSRV_FETCH_ASSOC);
                        $universityName = $rowUniversity['UNIVERSITY_NAME'];
                        echo $universityName;
                    }

                    echo "</td><td>";

                    
                    $sqlFindInstitute = "SELECT INSTITUTE_NAME FROM INSTITUTE WHERE INSTITUTE_ID = ?";
                    $paramsFindInstitute = array($instituteId);
                    $stmtFindInstitute = sqlsrv_query($conn, $sqlFindInstitute, $paramsFindInstitute);

                    if ($stmtFindInstitute && sqlsrv_has_rows($stmtFindInstitute)) {
                        $rowInstitute = sqlsrv_fetch_array($stmtFindInstitute, SQLSRV_FETCH_ASSOC);
                        $instituteName = $rowInstitute['INSTITUTE_NAME'];
                        echo $instituteName;
                    }

                    echo "</td><td>$numberofPages</td><td>";

                    
                    $sqlFindLanguage = "SELECT LANGUAGE_NAME FROM LANGUAGE WHERE LANGUAGE_ID = ?";
                    $paramsFindLanguage = array($languageId);
                    $stmtFindLanguage = sqlsrv_query($conn, $sqlFindLanguage, $paramsFindLanguage);

                    if ($stmtFindLanguage && sqlsrv_has_rows($stmtFindLanguage)) {
                        $rowLanguage = sqlsrv_fetch_array($stmtFindLanguage, SQLSRV_FETCH_ASSOC);
                        $languageName = $rowLanguage['LANGUAGE_NAME'];
                        echo $languageName;
                    }

                    echo "</td><td>";

                    
                    $sqlFindCosupervisor = "SELECT COSUPERVISOR_NAME,COSUPERVISOR_LASTNAME FROM COSUPERVISOR WHERE COSUPERVISOR_ID = ?";
                    $paramsFindCosupervisor = array($cosupervisorId);
                    $stmtFindCosupervisor = sqlsrv_query($conn, $sqlFindCosupervisor, $paramsFindCosupervisor);

                    if ($stmtFindCosupervisor && sqlsrv_has_rows($stmtFindCosupervisor)) {
                        $rowCosupervisor = sqlsrv_fetch_array($stmtFindCosupervisor, SQLSRV_FETCH_ASSOC);
                        $cosupervisorName = $rowCosupervisor['COSUPERVISOR_NAME'];
                        $cosupervisorlastName = $rowCosupervisor['COSUPERVISOR_LASTNAME'];
                        echo $cosupervisorName . ' ' . $cosupervisorlastName;
                    }

                    echo "</td><td>";

                    
                    $sqlFindAuthor = "SELECT AUTHOR_NAME, AUTHOR_LASTNAME FROM AUTHOR WHERE AUTHOR_ID = ?";
                    $paramsFindAuthor = array($authorId);
                    $stmtFindAuthor = sqlsrv_query($conn, $sqlFindAuthor, $paramsFindAuthor);

                    if ($stmtFindAuthor && sqlsrv_has_rows($stmtFindAuthor)) {
                        $rowAuthor = sqlsrv_fetch_array($stmtFindAuthor, SQLSRV_FETCH_ASSOC);
                        $authorName = $rowAuthor['AUTHOR_NAME'];
                        $authorlastName = $rowAuthor['AUTHOR_LASTNAME'];
                        echo $authorName . ' ' . $authorlastName;
                    }

                    echo "</td><td>";


                    $sqlFindsupervisorId = "SELECT SUPERVISOR_ID FROM SUPERVISOR_THESIS WHERE THESIS_ID = ?";
                    $paramsFindsupervisorId = array($thesisId);
                    $stmtFindsupervisorId = sqlsrv_query($conn, $sqlFindsupervisorId, $paramsFindsupervisorId);

                    if ($stmtFindsupervisorId && sqlsrv_has_rows($stmtFindsupervisorId)) {
                        $rowsupervisor = sqlsrv_fetch_array($stmtFindsupervisorId, SQLSRV_FETCH_ASSOC);
                        $supervisorId = $rowsupervisor['SUPERVISOR_ID'];
                    }

                    
                    $sqlFindSupervisor = "SELECT SUPERVISOR_NAME,SUPERVISOR_LASTNAME FROM SUPERVISOR WHERE SUPERVISOR_ID = ?";
                    $paramsFindSupervisor = array($supervisorId);
                    $stmtFindSupervisor = sqlsrv_query($conn, $sqlFindSupervisor, $paramsFindSupervisor);

                    if ($stmtFindSupervisor && sqlsrv_has_rows($stmtFindSupervisor)) {
                        $rowSupervisor = sqlsrv_fetch_array($stmtFindSupervisor, SQLSRV_FETCH_ASSOC);
                        $supervisorName = $rowSupervisor['SUPERVISOR_NAME'];
                        $supervisorlastName = $rowSupervisor['SUPERVISOR_LASTNAME'];
                        echo $supervisorName . ' ' . $supervisorlastName;
                    }

                    echo "</td><td>";

                    
                    $sqlFindKeywordsId = "SELECT KEYWORDS_ID FROM KEYWORD_THESIS WHERE THESIS_ID = ?";
                    $paramsFindKeywordsId = array($thesisId);
                    $stmtFindKeywordsId = sqlsrv_query($conn, $sqlFindKeywordsId, $paramsFindKeywordsId);

                    $keywords = array(); 

                    if ($stmtFindKeywordsId && sqlsrv_has_rows($stmtFindKeywordsId)) {
                        while ($rowKeyword = sqlsrv_fetch_array($stmtFindKeywordsId, SQLSRV_FETCH_ASSOC)) {
                            $keywords[] = $rowKeyword['KEYWORDS_ID']; 
                        }
                    }

                    
                    foreach ($keywords as $keywordId) {
                        $sqlFindKeywords = "SELECT KEYWORD FROM KEYWORDS WHERE KEYWORDS_ID = ?";
                        $paramsFindKeywords = array($keywordId);
                        $stmtFindKeywords = sqlsrv_query($conn, $sqlFindKeywords, $paramsFindKeywords);

                        if ($stmtFindKeywords && sqlsrv_has_rows($stmtFindKeywords)) {
                            $rowKeyword = sqlsrv_fetch_array($stmtFindKeywords, SQLSRV_FETCH_ASSOC);
                            $keyword = $rowKeyword['KEYWORD'];
                            echo $keyword . "<br>"; 
                        }
                    }

                    echo "</td><td>";

                    
                    $sqlFindTopicsId = "SELECT TOPICS_ID FROM THESIS_TOPICS WHERE THESIS_ID = ?";
                    $paramsFindTopicsId = array($thesisId);
                    $stmtFindTopicsId = sqlsrv_query($conn, $sqlFindTopicsId, $paramsFindTopicsId);

                    if ($stmtFindTopicsId && sqlsrv_has_rows($stmtFindTopicsId)) {
                        $rowTopics = sqlsrv_fetch_array($stmtFindTopicsId, SQLSRV_FETCH_ASSOC);
                        $TopicsId = $rowTopics['TOPICS_ID'];
                    }

                    $sqlFindTopics = "SELECT TOPICS_NAME FROM TOPICS WHERE TOPICS_ID = ?";
                    $paramsFindTopics = array($TopicsId);
                    $stmtFindTopics = sqlsrv_query($conn, $sqlFindTopics, $paramsFindTopics);

                    if ($stmtFindTopics && sqlsrv_has_rows($stmtFindTopics)) {
                        $rowTopics = sqlsrv_fetch_array($stmtFindTopics, SQLSRV_FETCH_ASSOC);
                        $Topics = $rowTopics['TOPICS_NAME'];

                        echo $Topics;
                    }

                    echo "</td><tr>";
                }
            }
        }
        echo "</table>";




    } else {
        echo "Veri bulunamadý.";
    }
}

    else if ($searchField === "AUTHOR_NAME") {
    // Kullanýcýdan alýnan isim-soyisim deðerini boþluk karakterine göre ayýrma
    $authorFullName = $searchTerm;
    $authorNameParts = explode(' ', $authorFullName);

    if (count($authorNameParts) > 1) {
        $authorName = $authorNameParts[0];
        $authorLastName = $authorNameParts[1];
    } else {
        $authorName = $authorFullName;
        $authorLastName = null; // Eðer sadece isim verilmiþse soyisimi kontrol etme
    }

    // Author Name ve Author Lastname deðerlerini kontrol etmek üzere sorgu oluþturma
    if ($authorLastName !== null) {
        // Eðer soyisim varsa hem isim hem soyisim üzerinden sorgu yap
        $sqlFindAuthorId = "SELECT AUTHOR_ID,AUTHOR_LASTNAME FROM AUTHOR WHERE AUTHOR_NAME = ? AND AUTHOR_LASTNAME = ?";
        $paramsFindAuthorId = array($authorName, $authorLastName);
    } else {
        // Eðer sadece isim varsa sadece isim üzerinden sorgu yap
        $sqlFindAuthorId = "SELECT AUTHOR_ID,AUTHOR_LASTNAME FROM AUTHOR WHERE AUTHOR_NAME = ?";
        $paramsFindAuthorId = array($authorName);
    }
    $authorId = 0;
    $stmtFindAuthorId = sqlsrv_query($conn, $sqlFindAuthorId, $paramsFindAuthorId);

    if ($stmtFindAuthorId && sqlsrv_has_rows($stmtFindAuthorId)) {
        $row = sqlsrv_fetch_array($stmtFindAuthorId, SQLSRV_FETCH_ASSOC);
        $authorId = $row['AUTHOR_ID'];
        $authorName = $authorName;
        $authorlastName = $row['AUTHOR_LASTNAME'];
    }

    $sqlFindThesis = "SELECT THESIS_ID, THESIS_NO, THESIS_TITLE, THESIS_ABSTRACT, AUTHOR_ID, THESIS_YEAR, THESIS_TYPE, UNIVERSITY_ID, INSTITUTE_ID, NUMBER_OF_PAGES, LANGUAGE_ID, SUBMISSION_DATE, COSUPERVISOR_ID FROM THESIS WHERE AUTHOR_ID = ?";
    $paramsFindThesis = array($authorId);
    $stmtFindThesis = sqlsrv_query($conn, $sqlFindThesis, $paramsFindThesis);
    echo "<table border='1'>";
    echo "<tr><th>Thesis ID</th><th>Thesis No</th><th>Thesis Title</th><th>Thesis Abstract</th><th>Thesis Year</th><th>Thesis Type</th><th>Submission Date</th><th>University</th><th>Institute</th><th>Number of Pages</th><th>Language</th><th>Cosupervisor</th><th>Author</th><th>Supervisor</th><th>Keywords</th><th>Topics</th></tr>";
    while ($row = sqlsrv_fetch_array($stmtFindThesis, SQLSRV_FETCH_ASSOC)) {
                $thesisId = $row['THESIS_ID'];
                $thesisNo = $row['THESIS_NO'];
                $thesisTitle = $row['THESIS_TITLE'];
                $thesisAbstract = $row['THESIS_ABSTRACT'];
                $authorId = $row['AUTHOR_ID'];
                $thesisYear = $row['THESIS_YEAR'];
                $thesisType = $row['THESIS_TYPE'];
                $universityId = $row['UNIVERSITY_ID'];
                $instituteId = $row['INSTITUTE_ID'];
                $numberofPages = $row['NUMBER_OF_PAGES'];
                $languageId = $row['LANGUAGE_ID'];
                $submissionDate = $row['SUBMISSION_DATE'];
                $cosupervisorId = $row['COSUPERVISOR_ID'];

                echo "<tr><td>$thesisId</td><td>$thesisNo</td><td>$thesisTitle</td><td>$thesisAbstract</td><td>$thesisYear</td><td>$thesisType</td><td>" . $submissionDate->format('Y-m-d') . "</td><td>";

                $sqlFindUniversity = "SELECT UNIVERSITY_NAME FROM UNIVERSITY WHERE UNIVERSITY_ID = ?";
                $paramsFindUniversity = array($universityId);
                $stmtFindUniversity = sqlsrv_query($conn, $sqlFindUniversity, $paramsFindUniversity);

                if ($stmtFindUniversity && sqlsrv_has_rows($stmtFindUniversity)) {
                    $row = sqlsrv_fetch_array($stmtFindUniversity, SQLSRV_FETCH_ASSOC);
                    $universityName = $row['UNIVERSITY_NAME'];
                    echo $universityName;
                }

                echo "</td><td>";

                
                $sqlFindInstitute = "SELECT INSTITUTE_NAME FROM INSTITUTE WHERE INSTITUTE_ID = ?";
                $paramsFindInstitute = array($instituteId);
                $stmtFindInstitute = sqlsrv_query($conn, $sqlFindInstitute, $paramsFindInstitute);

                if ($stmtFindInstitute && sqlsrv_has_rows($stmtFindInstitute)) {
                    $row = sqlsrv_fetch_array($stmtFindInstitute, SQLSRV_FETCH_ASSOC);
                    $instituteName = $row['INSTITUTE_NAME'];
                    echo $instituteName;
                }

                echo "</td><td>$numberofPages</td><td>";

                
                $sqlFindLanguage = "SELECT LANGUAGE_NAME FROM LANGUAGE WHERE LANGUAGE_ID = ?";
                $paramsFindLanguage = array($languageId);
                $stmtFindLanguage = sqlsrv_query($conn, $sqlFindLanguage, $paramsFindLanguage);

                if ($stmtFindLanguage && sqlsrv_has_rows($stmtFindLanguage)) {
                    $row = sqlsrv_fetch_array($stmtFindLanguage, SQLSRV_FETCH_ASSOC);
                    $languageName = $row['LANGUAGE_NAME'];
                    echo $languageName;
                }

                echo "</td><td>";

                
                $sqlFindCosupervisor = "SELECT COSUPERVISOR_NAME,COSUPERVISOR_LASTNAME FROM COSUPERVISOR WHERE COSUPERVISOR_ID = ?";
                $paramsFindCosupervisor = array($cosupervisorId);
                $stmtFindCosupervisor = sqlsrv_query($conn, $sqlFindCosupervisor, $paramsFindCosupervisor);

                if ($stmtFindCosupervisor && sqlsrv_has_rows($stmtFindCosupervisor)) {
                    $row = sqlsrv_fetch_array($stmtFindCosupervisor, SQLSRV_FETCH_ASSOC);
                    $cosupervisorName = $row['COSUPERVISOR_NAME'];
                    $cosupervisorlastName = $row['COSUPERVISOR_LASTNAME'];
                    echo $cosupervisorName . ' ' . $cosupervisorlastName;
                }

                echo "</td><td>";

        
                echo $authorName . ' ' . $authorlastName;
                echo "</td><td>";

                $sqlFindSupervisorId = "SELECT SUPERVISOR_ID FROM SUPERVISOR_THESIS WHERE THESIS_ID = ?";
                $paramsFindSupervisorId = array($thesisId);
                $stmtFindSupervisorId = sqlsrv_query($conn, $sqlFindSupervisorId, $paramsFindSupervisorId);

                if ($stmtFindSupervisorId && sqlsrv_has_rows($stmtFindSupervisorId)) {
                    $row = sqlsrv_fetch_array($stmtFindSupervisorId, SQLSRV_FETCH_ASSOC);
                    $supervisorId = $row['SUPERVISOR_ID'];                   
                }

                $sqlFindSupervisor = "SELECT SUPERVISOR_NAME,SUPERVISOR_LASTNAME FROM SUPERVISOR WHERE SUPERVISOR_ID = ?";
                $paramsFindSupervisor = array($supervisorId);
                $stmtFindSupervisor = sqlsrv_query($conn, $sqlFindSupervisor, $paramsFindSupervisor);

                if ($stmtFindSupervisor && sqlsrv_has_rows($stmtFindSupervisor)) {
                    $row = sqlsrv_fetch_array($stmtFindSupervisor, SQLSRV_FETCH_ASSOC);
                    $supervisorName = $row['SUPERVISOR_NAME'];
                    $supervisorlastName = $row['SUPERVISOR_LASTNAME'];
                    echo $supervisorName . ' ' . $supervisorlastName;
                }

                echo "</td><td>";

                $sqlFindKeywordsId = "SELECT KEYWORDS_ID FROM KEYWORD_THESIS WHERE THESIS_ID = ?";
                $paramsFindKeywordsId = array($thesisId);
                $stmtFindKeywordsId = sqlsrv_query($conn, $sqlFindKeywordsId, $paramsFindKeywordsId);

                $keywords = array(); 

                if ($stmtFindKeywordsId && sqlsrv_has_rows($stmtFindKeywordsId)) {
                    while ($row = sqlsrv_fetch_array($stmtFindKeywordsId, SQLSRV_FETCH_ASSOC)) {
                        $keywords[] = $row['KEYWORDS_ID']; 
                    }
                }



                
                foreach ($keywords as $keywordId) {
                    $sqlFindKeywords = "SELECT KEYWORD FROM KEYWORDS WHERE KEYWORDS_ID = ?";
                    $paramsFindKeywords = array($keywordId);
                    $stmtFindKeywords = sqlsrv_query($conn, $sqlFindKeywords, $paramsFindKeywords);

                    if ($stmtFindKeywords && sqlsrv_has_rows($stmtFindKeywords)) {
                        $row = sqlsrv_fetch_array($stmtFindKeywords, SQLSRV_FETCH_ASSOC);
                        $keyword = $row['KEYWORD'];
                        echo $keyword . "<br>"; 
                    }
                }






                echo "</td><td>";


                $sqlFindTopicsId = "SELECT TOPICS_ID FROM THESIS_TOPICS WHERE THESIS_ID = ?";
                $paramsFindTopicsId = array($thesisId);
                $stmtFindTopicsId = sqlsrv_query($conn, $sqlFindTopicsId, $paramsFindTopicsId);

                if ($stmtFindTopicsId && sqlsrv_has_rows($stmtFindTopicsId)) {
                    $row = sqlsrv_fetch_array($stmtFindTopicsId, SQLSRV_FETCH_ASSOC);
                    $TopicsId = $row['TOPICS_ID'];                   
                }

                $sqlFindTopics = "SELECT TOPICS_NAME FROM TOPICS WHERE TOPICS_ID = ?";
                $paramsFindTopics = array($TopicsId);
                $stmtFindTopics = sqlsrv_query($conn, $sqlFindTopics, $paramsFindTopics);

                if ($stmtFindTopics && sqlsrv_has_rows($stmtFindTopics)) {
                    $row = sqlsrv_fetch_array($stmtFindTopics, SQLSRV_FETCH_ASSOC);
                    $Topics = $row['TOPICS_NAME'];
                    
                    echo $Topics;
                }

                echo "</td><tr>";
        
    }
    echo "</table>";
    }


    
    else if ($searchField === "LANGUAGE_NAME") {
    $languageName = $searchTerm;
    $sqlFindlanguageId = "SELECT LANGUAGE_ID FROM LANGUAGE WHERE LANGUAGE_NAME = ?";
    $paramsFindlanguageId = array($languageName);
    $stmtFindlanguageId = sqlsrv_query($conn, $sqlFindlanguageId, $paramsFindlanguageId);

    if ($stmtFindlanguageId) {
        echo "<table border='1'>";
        echo "<tr><th>Thesis ID</th><th>Thesis No</th><th>Thesis Title</th><th>Thesis Abstract</th><th>Thesis Year</th><th>Thesis Type</th><th>Submission Date</th><th>University</th><th>Institute</th><th>Number of Pages</th><th>Language</th><th>Cosupervisor</th><th>Author</th><th>Supervisor</th><th>Keywords</th><th>Topics</th></tr>";
        while ($row = sqlsrv_fetch_array($stmtFindlanguageId, SQLSRV_FETCH_ASSOC)) {
            $languageId = $row['LANGUAGE_ID'];

            
            $sqlFindcosupervisorThesis = "SELECT THESIS_ID FROM THESIS WHERE LANGUAGE_ID = ?";
            $paramsFindcosupervisorThesis = array($languageId);
            $stmtFindcosupervisorThesis = sqlsrv_query($conn, $sqlFindcosupervisorThesis, $paramsFindcosupervisorThesis);

            while ($rowThesis = sqlsrv_fetch_array($stmtFindcosupervisorThesis, SQLSRV_FETCH_ASSOC)) {
                $thesisId = $rowThesis['THESIS_ID'];

               
                $sqlFindThesis = "SELECT THESIS_ID, THESIS_NO, THESIS_TITLE, THESIS_ABSTRACT, AUTHOR_ID, THESIS_YEAR, THESIS_TYPE, UNIVERSITY_ID, INSTITUTE_ID, NUMBER_OF_PAGES, LANGUAGE_ID, SUBMISSION_DATE, COSUPERVISOR_ID FROM THESIS WHERE THESIS_ID = ?";
                $paramsFindThesis = array($thesisId);
                $stmtFindThesis = sqlsrv_query($conn, $sqlFindThesis, $paramsFindThesis);

                while ($rowThesisDetails = sqlsrv_fetch_array($stmtFindThesis, SQLSRV_FETCH_ASSOC)) {
                    $thesisId = $rowThesisDetails['THESIS_ID'];
                    $thesisNo = $rowThesisDetails['THESIS_NO'];
                    $thesisTitle = $rowThesisDetails['THESIS_TITLE'];
                    $thesisAbstract = $rowThesisDetails['THESIS_ABSTRACT'];
                    $authorId = $rowThesisDetails['AUTHOR_ID'];
                    $thesisYear = $rowThesisDetails['THESIS_YEAR'];
                    $thesisType = $rowThesisDetails['THESIS_TYPE'];
                    $universityId = $rowThesisDetails['UNIVERSITY_ID'];
                    $instituteId = $rowThesisDetails['INSTITUTE_ID'];
                    $numberofPages = $rowThesisDetails['NUMBER_OF_PAGES'];
                    $languageId = $rowThesisDetails['LANGUAGE_ID'];
                    $submissionDate = $rowThesisDetails['SUBMISSION_DATE'];
                    $cosupervisorId = $rowThesisDetails['COSUPERVISOR_ID'];

                    echo "<tr><td>$thesisId</td><td>$thesisNo</td><td>$thesisTitle</td><td>$thesisAbstract</td><td>$thesisYear</td><td>$thesisType</td><td>" . $submissionDate->format('Y-m-d') . "</td><td>";

                    
                    $sqlFindUniversity = "SELECT UNIVERSITY_NAME FROM UNIVERSITY WHERE UNIVERSITY_ID = ?";
                    $paramsFindUniversity = array($universityId);
                    $stmtFindUniversity = sqlsrv_query($conn, $sqlFindUniversity, $paramsFindUniversity);

                    if ($stmtFindUniversity && sqlsrv_has_rows($stmtFindUniversity)) {
                        $rowUniversity = sqlsrv_fetch_array($stmtFindUniversity, SQLSRV_FETCH_ASSOC);
                        $universityName = $rowUniversity['UNIVERSITY_NAME'];
                        echo $universityName;
                    }

                    echo "</td><td>";

                    
                    $sqlFindInstitute = "SELECT INSTITUTE_NAME FROM INSTITUTE WHERE INSTITUTE_ID = ?";
                    $paramsFindInstitute = array($instituteId);
                    $stmtFindInstitute = sqlsrv_query($conn, $sqlFindInstitute, $paramsFindInstitute);

                    if ($stmtFindInstitute && sqlsrv_has_rows($stmtFindInstitute)) {
                        $rowInstitute = sqlsrv_fetch_array($stmtFindInstitute, SQLSRV_FETCH_ASSOC);
                        $instituteName = $rowInstitute['INSTITUTE_NAME'];
                        echo $instituteName;
                    }

                    echo "</td><td>$numberofPages</td><td>";

                    
                    $sqlFindLanguage = "SELECT LANGUAGE_NAME FROM LANGUAGE WHERE LANGUAGE_ID = ?";
                    $paramsFindLanguage = array($languageId);
                    $stmtFindLanguage = sqlsrv_query($conn, $sqlFindLanguage, $paramsFindLanguage);

                    if ($stmtFindLanguage && sqlsrv_has_rows($stmtFindLanguage)) {
                        $rowLanguage = sqlsrv_fetch_array($stmtFindLanguage, SQLSRV_FETCH_ASSOC);
                        $languageName = $rowLanguage['LANGUAGE_NAME'];
                        echo $languageName;
                    }

                    echo "</td><td>";

                    
                    $sqlFindCosupervisor = "SELECT COSUPERVISOR_NAME,COSUPERVISOR_LASTNAME FROM COSUPERVISOR WHERE COSUPERVISOR_ID = ?";
                    $paramsFindCosupervisor = array($cosupervisorId);
                    $stmtFindCosupervisor = sqlsrv_query($conn, $sqlFindCosupervisor, $paramsFindCosupervisor);

                    if ($stmtFindCosupervisor && sqlsrv_has_rows($stmtFindCosupervisor)) {
                        $rowCosupervisor = sqlsrv_fetch_array($stmtFindCosupervisor, SQLSRV_FETCH_ASSOC);
                        $cosupervisorName = $rowCosupervisor['COSUPERVISOR_NAME'];
                        $cosupervisorlastName = $rowCosupervisor['COSUPERVISOR_LASTNAME'];
                        echo $cosupervisorName . ' ' . $cosupervisorlastName;
                    }

                    echo "</td><td>";

                    
                    $sqlFindAuthor = "SELECT AUTHOR_NAME, AUTHOR_LASTNAME FROM AUTHOR WHERE AUTHOR_ID = ?";
                    $paramsFindAuthor = array($authorId);
                    $stmtFindAuthor = sqlsrv_query($conn, $sqlFindAuthor, $paramsFindAuthor);

                    if ($stmtFindAuthor && sqlsrv_has_rows($stmtFindAuthor)) {
                        $rowAuthor = sqlsrv_fetch_array($stmtFindAuthor, SQLSRV_FETCH_ASSOC);
                        $authorName = $rowAuthor['AUTHOR_NAME'];
                        $authorlastName = $rowAuthor['AUTHOR_LASTNAME'];
                        echo $authorName . ' ' . $authorlastName;
                    }

                    echo "</td><td>";


                    $sqlFindsupervisorId = "SELECT SUPERVISOR_ID FROM SUPERVISOR_THESIS WHERE THESIS_ID = ?";
                    $paramsFindsupervisorId = array($thesisId);
                    $stmtFindsupervisorId = sqlsrv_query($conn, $sqlFindsupervisorId, $paramsFindsupervisorId);

                    if ($stmtFindsupervisorId && sqlsrv_has_rows($stmtFindsupervisorId)) {
                        $rowsupervisor = sqlsrv_fetch_array($stmtFindsupervisorId, SQLSRV_FETCH_ASSOC);
                        $supervisorId = $rowsupervisor['SUPERVISOR_ID'];
                    }

                    
                    $sqlFindSupervisor = "SELECT SUPERVISOR_NAME,SUPERVISOR_LASTNAME FROM SUPERVISOR WHERE SUPERVISOR_ID = ?";
                    $paramsFindSupervisor = array($supervisorId);
                    $stmtFindSupervisor = sqlsrv_query($conn, $sqlFindSupervisor, $paramsFindSupervisor);

                    if ($stmtFindSupervisor && sqlsrv_has_rows($stmtFindSupervisor)) {
                        $rowSupervisor = sqlsrv_fetch_array($stmtFindSupervisor, SQLSRV_FETCH_ASSOC);
                        $supervisorName = $rowSupervisor['SUPERVISOR_NAME'];
                        $supervisorlastName = $rowSupervisor['SUPERVISOR_LASTNAME'];
                        echo $supervisorName . ' ' . $supervisorlastName;
                    }

                    echo "</td><td>";

                    
                    $sqlFindKeywordsId = "SELECT KEYWORDS_ID FROM KEYWORD_THESIS WHERE THESIS_ID = ?";
                    $paramsFindKeywordsId = array($thesisId);
                    $stmtFindKeywordsId = sqlsrv_query($conn, $sqlFindKeywordsId, $paramsFindKeywordsId);

                    $keywords = array(); 

                    if ($stmtFindKeywordsId && sqlsrv_has_rows($stmtFindKeywordsId)) {
                        while ($rowKeyword = sqlsrv_fetch_array($stmtFindKeywordsId, SQLSRV_FETCH_ASSOC)) {
                            $keywords[] = $rowKeyword['KEYWORDS_ID']; 
                        }
                    }

                    
                    foreach ($keywords as $keywordId) {
                        $sqlFindKeywords = "SELECT KEYWORD FROM KEYWORDS WHERE KEYWORDS_ID = ?";
                        $paramsFindKeywords = array($keywordId);
                        $stmtFindKeywords = sqlsrv_query($conn, $sqlFindKeywords, $paramsFindKeywords);

                        if ($stmtFindKeywords && sqlsrv_has_rows($stmtFindKeywords)) {
                            $rowKeyword = sqlsrv_fetch_array($stmtFindKeywords, SQLSRV_FETCH_ASSOC);
                            $keyword = $rowKeyword['KEYWORD'];
                            echo $keyword . "<br>"; 
                        }
                    }

                    echo "</td><td>";

                    
                    $sqlFindTopicsId = "SELECT TOPICS_ID FROM THESIS_TOPICS WHERE THESIS_ID = ?";
                    $paramsFindTopicsId = array($thesisId);
                    $stmtFindTopicsId = sqlsrv_query($conn, $sqlFindTopicsId, $paramsFindTopicsId);

                    if ($stmtFindTopicsId && sqlsrv_has_rows($stmtFindTopicsId)) {
                        $rowTopics = sqlsrv_fetch_array($stmtFindTopicsId, SQLSRV_FETCH_ASSOC);
                        $TopicsId = $rowTopics['TOPICS_ID'];
                    }

                    $sqlFindTopics = "SELECT TOPICS_NAME FROM TOPICS WHERE TOPICS_ID = ?";
                    $paramsFindTopics = array($TopicsId);
                    $stmtFindTopics = sqlsrv_query($conn, $sqlFindTopics, $paramsFindTopics);

                    if ($stmtFindTopics && sqlsrv_has_rows($stmtFindTopics)) {
                        $rowTopics = sqlsrv_fetch_array($stmtFindTopics, SQLSRV_FETCH_ASSOC);
                        $Topics = $rowTopics['TOPICS_NAME'];

                        echo $Topics;
                    }

                    echo "</td><tr>";
                }
            }
        }
        echo "</table>";




    } else {
        echo "Veri bulunamadý.";
    }
}


  

    else if ($searchField === "UNIVERSITY_NAME") {
    $universityName = $searchTerm;

    
    $sqlFindUniversityId = "SELECT UNIVERSITY_ID FROM UNIVERSITY WHERE UNIVERSITY_NAME LIKE ?";
    $paramsFindUniversityId = array("%$universityName%");

    
    $stmtFindUniversityId = sqlsrv_query($conn, $sqlFindUniversityId, $paramsFindUniversityId);

    if ($stmtFindUniversityId === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($stmtFindUniversityId)) {
        echo "<table border='1'>";
        echo "<tr><th>Thesis ID</th><th>Thesis No</th><th>Thesis Title</th><th>Thesis Abstract</th><th>Thesis Year</th><th>Thesis Type</th><th>Submission Date</th><th>University</th><th>Institute</th><th>Number of Pages</th><th>Language</th><th>Cosupervisor</th><th>Author</th><th>Supervisor</th><th>Keywords</th><th>Topics</th></tr>";

        while ($rowUniversity = sqlsrv_fetch_array($stmtFindUniversityId, SQLSRV_FETCH_ASSOC)) {
            $universityId = $rowUniversity['UNIVERSITY_ID'];

            $sqlFindThesis = "SELECT THESIS_ID, THESIS_NO, THESIS_TITLE, THESIS_ABSTRACT, AUTHOR_ID, THESIS_YEAR, THESIS_TYPE, UNIVERSITY_ID, INSTITUTE_ID, NUMBER_OF_PAGES, LANGUAGE_ID, SUBMISSION_DATE, COSUPERVISOR_ID FROM THESIS WHERE UNIVERSITY_ID = ?";
            $paramsFindThesis = array($universityId);
            $stmtFindThesis = sqlsrv_query($conn, $sqlFindThesis, $paramsFindThesis);

                while ($rowThesisDetails = sqlsrv_fetch_array($stmtFindThesis, SQLSRV_FETCH_ASSOC)) {
                    $thesisId = $rowThesisDetails['THESIS_ID'];
                    $thesisNo = $rowThesisDetails['THESIS_NO'];
                    $thesisTitle = $rowThesisDetails['THESIS_TITLE'];
                    $thesisAbstract = $rowThesisDetails['THESIS_ABSTRACT'];
                    $authorId = $rowThesisDetails['AUTHOR_ID'];
                    $thesisYear = $rowThesisDetails['THESIS_YEAR'];
                    $thesisType = $rowThesisDetails['THESIS_TYPE'];
                    $universityId = $rowThesisDetails['UNIVERSITY_ID'];
                    $instituteId = $rowThesisDetails['INSTITUTE_ID'];
                    $numberofPages = $rowThesisDetails['NUMBER_OF_PAGES'];
                    $languageId = $rowThesisDetails['LANGUAGE_ID'];
                    $submissionDate = $rowThesisDetails['SUBMISSION_DATE'];
                    $cosupervisorId = $rowThesisDetails['COSUPERVISOR_ID'];

                    echo "<tr><td>$thesisId</td><td>$thesisNo</td><td>$thesisTitle</td><td>$thesisAbstract</td><td>$thesisYear</td><td>$thesisType</td><td>" . $submissionDate->format('Y-m-d') . "</td><td>";

                    
                    $sqlFindUniversity = "SELECT UNIVERSITY_NAME FROM UNIVERSITY WHERE UNIVERSITY_ID = ?";
                    $paramsFindUniversity = array($universityId);
                    $stmtFindUniversity = sqlsrv_query($conn, $sqlFindUniversity, $paramsFindUniversity);

                    if ($stmtFindUniversity && sqlsrv_has_rows($stmtFindUniversity)) {
                        $rowUniversity = sqlsrv_fetch_array($stmtFindUniversity, SQLSRV_FETCH_ASSOC);
                        $universityName = $rowUniversity['UNIVERSITY_NAME'];
                        echo $universityName;
                    }

                    echo "</td><td>";

                   
                    $sqlFindInstitute = "SELECT INSTITUTE_NAME FROM INSTITUTE WHERE INSTITUTE_ID = ?";
                    $paramsFindInstitute = array($instituteId);
                    $stmtFindInstitute = sqlsrv_query($conn, $sqlFindInstitute, $paramsFindInstitute);

                    if ($stmtFindInstitute && sqlsrv_has_rows($stmtFindInstitute)) {
                        $rowInstitute = sqlsrv_fetch_array($stmtFindInstitute, SQLSRV_FETCH_ASSOC);
                        $instituteName = $rowInstitute['INSTITUTE_NAME'];
                        echo $instituteName;
                    }

                    echo "</td><td>$numberofPages</td><td>";

                    // Language Name
                    $sqlFindLanguage = "SELECT LANGUAGE_NAME FROM LANGUAGE WHERE LANGUAGE_ID = ?";
                    $paramsFindLanguage = array($languageId);
                    $stmtFindLanguage = sqlsrv_query($conn, $sqlFindLanguage, $paramsFindLanguage);

                    if ($stmtFindLanguage && sqlsrv_has_rows($stmtFindLanguage)) {
                        $rowLanguage = sqlsrv_fetch_array($stmtFindLanguage, SQLSRV_FETCH_ASSOC);
                        $languageName = $rowLanguage['LANGUAGE_NAME'];
                        echo $languageName;
                    }

                    echo "</td><td>";

                    // Cosupervisor Name
                    $sqlFindCosupervisor = "SELECT COSUPERVISOR_NAME,COSUPERVISOR_LASTNAME FROM COSUPERVISOR WHERE COSUPERVISOR_ID = ?";
                    $paramsFindCosupervisor = array($cosupervisorId);
                    $stmtFindCosupervisor = sqlsrv_query($conn, $sqlFindCosupervisor, $paramsFindCosupervisor);

                    if ($stmtFindCosupervisor && sqlsrv_has_rows($stmtFindCosupervisor)) {
                        $rowCosupervisor = sqlsrv_fetch_array($stmtFindCosupervisor, SQLSRV_FETCH_ASSOC);
                        $cosupervisorName = $rowCosupervisor['COSUPERVISOR_NAME'];
                        $cosupervisorlastName = $rowCosupervisor['COSUPERVISOR_LASTNAME'];
                        echo $cosupervisorName . ' ' . $cosupervisorlastName;
                    }

                    echo "</td><td>";

                    // Author Name
                    $sqlFindAuthor = "SELECT AUTHOR_NAME, AUTHOR_LASTNAME FROM AUTHOR WHERE AUTHOR_ID = ?";
                    $paramsFindAuthor = array($authorId);
                    $stmtFindAuthor = sqlsrv_query($conn, $sqlFindAuthor, $paramsFindAuthor);

                    if ($stmtFindAuthor && sqlsrv_has_rows($stmtFindAuthor)) {
                        $rowAuthor = sqlsrv_fetch_array($stmtFindAuthor, SQLSRV_FETCH_ASSOC);
                        $authorName = $rowAuthor['AUTHOR_NAME'];
                        $authorlastName = $rowAuthor['AUTHOR_LASTNAME'];
                        echo $authorName . ' ' . $authorlastName;
                    }

                    echo "</td><td>";


                    $sqlFindsupervisorId = "SELECT SUPERVISOR_ID FROM SUPERVISOR_THESIS WHERE THESIS_ID = ?";
                    $paramsFindsupervisorId = array($thesisId);
                    $stmtFindsupervisorId = sqlsrv_query($conn, $sqlFindsupervisorId, $paramsFindsupervisorId);

                    if ($stmtFindsupervisorId && sqlsrv_has_rows($stmtFindsupervisorId)) {
                        $rowsupervisor = sqlsrv_fetch_array($stmtFindsupervisorId, SQLSRV_FETCH_ASSOC);
                        $supervisorId = $rowsupervisor['SUPERVISOR_ID'];
                    }

                    // Supervisor Name
                    $sqlFindSupervisor = "SELECT SUPERVISOR_NAME,SUPERVISOR_LASTNAME FROM SUPERVISOR WHERE SUPERVISOR_ID = ?";
                    $paramsFindSupervisor = array($supervisorId);
                    $stmtFindSupervisor = sqlsrv_query($conn, $sqlFindSupervisor, $paramsFindSupervisor);

                    if ($stmtFindSupervisor && sqlsrv_has_rows($stmtFindSupervisor)) {
                        $rowSupervisor = sqlsrv_fetch_array($stmtFindSupervisor, SQLSRV_FETCH_ASSOC);
                        $supervisorName = $rowSupervisor['SUPERVISOR_NAME'];
                        $supervisorlastName = $rowSupervisor['SUPERVISOR_LASTNAME'];
                        echo $supervisorName . ' ' . $supervisorlastName;
                    }

                    echo "</td><td>";

                    // Keywords
                    $sqlFindKeywordsId = "SELECT KEYWORDS_ID FROM KEYWORD_THESIS WHERE THESIS_ID = ?";
                    $paramsFindKeywordsId = array($thesisId);
                    $stmtFindKeywordsId = sqlsrv_query($conn, $sqlFindKeywordsId, $paramsFindKeywordsId);

                    $keywords = array(); // Keyword'leri saklamak için boþ bir dizi oluþturuyoruz.

                    if ($stmtFindKeywordsId && sqlsrv_has_rows($stmtFindKeywordsId)) {
                        while ($rowKeyword = sqlsrv_fetch_array($stmtFindKeywordsId, SQLSRV_FETCH_ASSOC)) {
                            $keywords[] = $rowKeyword['KEYWORDS_ID']; // Keyword ID'yi diziye ekliyoruz.
                        }
                    }

                    // Her bir keyword için ayrý bir sorgu yaparak sonuçlarý ekrana yazýyoruz.
                    foreach ($keywords as $keywordId) {
                        $sqlFindKeywords = "SELECT KEYWORD FROM KEYWORDS WHERE KEYWORDS_ID = ?";
                        $paramsFindKeywords = array($keywordId);
                        $stmtFindKeywords = sqlsrv_query($conn, $sqlFindKeywords, $paramsFindKeywords);

                        if ($stmtFindKeywords && sqlsrv_has_rows($stmtFindKeywords)) {
                            $rowKeyword = sqlsrv_fetch_array($stmtFindKeywords, SQLSRV_FETCH_ASSOC);
                            $keyword = $rowKeyword['KEYWORD'];
                            echo $keyword . "<br>"; // Her bir keyword'i yeni bir satýrda gösteriyoruz.
                        }
                    }

                    echo "</td><td>";

                    // Topics
                    $sqlFindTopicsId = "SELECT TOPICS_ID FROM THESIS_TOPICS WHERE THESIS_ID = ?";
                    $paramsFindTopicsId = array($thesisId);
                    $stmtFindTopicsId = sqlsrv_query($conn, $sqlFindTopicsId, $paramsFindTopicsId);

                    if ($stmtFindTopicsId && sqlsrv_has_rows($stmtFindTopicsId)) {
                        $rowTopics = sqlsrv_fetch_array($stmtFindTopicsId, SQLSRV_FETCH_ASSOC);
                        $TopicsId = $rowTopics['TOPICS_ID'];
                    }

                    $sqlFindTopics = "SELECT TOPICS_NAME FROM TOPICS WHERE TOPICS_ID = ?";
                    $paramsFindTopics = array($TopicsId);
                    $stmtFindTopics = sqlsrv_query($conn, $sqlFindTopics, $paramsFindTopics);

                    if ($stmtFindTopics && sqlsrv_has_rows($stmtFindTopics)) {
                        $rowTopics = sqlsrv_fetch_array($stmtFindTopics, SQLSRV_FETCH_ASSOC);
                        $Topics = $rowTopics['TOPICS_NAME'];

                        echo $Topics;
                    }

                    echo "</td><tr>";
                }
            
        }
        echo "</table>";




    } else {
        echo "Veri bulunamadý.";
    }
}

    else if ($searchField === "INSTITUTE_NAME") {
    $instituteName = $searchTerm;

    
    $sqlFindinstituteId = "SELECT UNIVERSITY_ID FROM INSTITUTE WHERE INSTITUTE_NAME LIKE ?";
    $paramsFindinstituteId = array("%$instituteName%");

    
    $stmtFindinstituteId = sqlsrv_query($conn, $sqlFindinstituteId, $paramsFindinstituteId);

    if ($stmtFindinstituteId === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($stmtFindinstituteId)) {
        echo "<table border='1'>";
        echo "<tr><th>Thesis ID</th><th>Thesis No</th><th>Thesis Title</th><th>Thesis Abstract</th><th>Thesis Year</th><th>Thesis Type</th><th>Submission Date</th><th>University</th><th>Institute</th><th>Number of Pages</th><th>Language</th><th>Cosupervisor</th><th>Author</th><th>Supervisor</th><th>Keywords</th><th>Topics</th></tr>";

        while ($rowinstitute = sqlsrv_fetch_array($stmtFindinstituteId, SQLSRV_FETCH_ASSOC)) {
            $universityId = $rowinstitute['UNIVERSITY_ID'];

            $sqlFindThesis = "SELECT THESIS_ID, THESIS_NO, THESIS_TITLE, THESIS_ABSTRACT, AUTHOR_ID, THESIS_YEAR, THESIS_TYPE, UNIVERSITY_ID, INSTITUTE_ID, NUMBER_OF_PAGES, LANGUAGE_ID, SUBMISSION_DATE, COSUPERVISOR_ID FROM THESIS WHERE UNIVERSITY_ID = ?";
            $paramsFindThesis = array($universityId);
            $stmtFindThesis = sqlsrv_query($conn, $sqlFindThesis, $paramsFindThesis);

                while ($rowThesisDetails = sqlsrv_fetch_array($stmtFindThesis, SQLSRV_FETCH_ASSOC)) {
                    $thesisId = $rowThesisDetails['THESIS_ID'];
                    $thesisNo = $rowThesisDetails['THESIS_NO'];
                    $thesisTitle = $rowThesisDetails['THESIS_TITLE'];
                    $thesisAbstract = $rowThesisDetails['THESIS_ABSTRACT'];
                    $authorId = $rowThesisDetails['AUTHOR_ID'];
                    $thesisYear = $rowThesisDetails['THESIS_YEAR'];
                    $thesisType = $rowThesisDetails['THESIS_TYPE'];
                    $universityId = $rowThesisDetails['UNIVERSITY_ID'];
                    $instituteId = $rowThesisDetails['INSTITUTE_ID'];
                    $numberofPages = $rowThesisDetails['NUMBER_OF_PAGES'];
                    $languageId = $rowThesisDetails['LANGUAGE_ID'];
                    $submissionDate = $rowThesisDetails['SUBMISSION_DATE'];
                    $cosupervisorId = $rowThesisDetails['COSUPERVISOR_ID'];

                    echo "<tr><td>$thesisId</td><td>$thesisNo</td><td>$thesisTitle</td><td>$thesisAbstract</td><td>$thesisYear</td><td>$thesisType</td><td>" . $submissionDate->format('Y-m-d') . "</td><td>";

                    
                    $sqlFindUniversity = "SELECT UNIVERSITY_NAME FROM UNIVERSITY WHERE UNIVERSITY_ID = ?";
                    $paramsFindUniversity = array($universityId);
                    $stmtFindUniversity = sqlsrv_query($conn, $sqlFindUniversity, $paramsFindUniversity);

                    if ($stmtFindUniversity && sqlsrv_has_rows($stmtFindUniversity)) {
                        $rowUniversity = sqlsrv_fetch_array($stmtFindUniversity, SQLSRV_FETCH_ASSOC);
                        $universityName = $rowUniversity['UNIVERSITY_NAME'];
                        echo $universityName;
                    }

                    echo "</td><td>";

                   
                    $sqlFindInstitute = "SELECT INSTITUTE_NAME FROM INSTITUTE WHERE INSTITUTE_ID = ?";
                    $paramsFindInstitute = array($instituteId);
                    $stmtFindInstitute = sqlsrv_query($conn, $sqlFindInstitute, $paramsFindInstitute);

                    if ($stmtFindInstitute && sqlsrv_has_rows($stmtFindInstitute)) {
                        $rowInstitute = sqlsrv_fetch_array($stmtFindInstitute, SQLSRV_FETCH_ASSOC);
                        $instituteName = $rowInstitute['INSTITUTE_NAME'];
                        echo $instituteName;
                    }

                    echo "</td><td>$numberofPages</td><td>";

                    // Language Name
                    $sqlFindLanguage = "SELECT LANGUAGE_NAME FROM LANGUAGE WHERE LANGUAGE_ID = ?";
                    $paramsFindLanguage = array($languageId);
                    $stmtFindLanguage = sqlsrv_query($conn, $sqlFindLanguage, $paramsFindLanguage);

                    if ($stmtFindLanguage && sqlsrv_has_rows($stmtFindLanguage)) {
                        $rowLanguage = sqlsrv_fetch_array($stmtFindLanguage, SQLSRV_FETCH_ASSOC);
                        $languageName = $rowLanguage['LANGUAGE_NAME'];
                        echo $languageName;
                    }

                    echo "</td><td>";

                    // Cosupervisor Name
                    $sqlFindCosupervisor = "SELECT COSUPERVISOR_NAME,COSUPERVISOR_LASTNAME FROM COSUPERVISOR WHERE COSUPERVISOR_ID = ?";
                    $paramsFindCosupervisor = array($cosupervisorId);
                    $stmtFindCosupervisor = sqlsrv_query($conn, $sqlFindCosupervisor, $paramsFindCosupervisor);

                    if ($stmtFindCosupervisor && sqlsrv_has_rows($stmtFindCosupervisor)) {
                        $rowCosupervisor = sqlsrv_fetch_array($stmtFindCosupervisor, SQLSRV_FETCH_ASSOC);
                        $cosupervisorName = $rowCosupervisor['COSUPERVISOR_NAME'];
                        $cosupervisorlastName = $rowCosupervisor['COSUPERVISOR_LASTNAME'];
                        echo $cosupervisorName . ' ' . $cosupervisorlastName;
                    }

                    echo "</td><td>";

                    // Author Name
                    $sqlFindAuthor = "SELECT AUTHOR_NAME, AUTHOR_LASTNAME FROM AUTHOR WHERE AUTHOR_ID = ?";
                    $paramsFindAuthor = array($authorId);
                    $stmtFindAuthor = sqlsrv_query($conn, $sqlFindAuthor, $paramsFindAuthor);

                    if ($stmtFindAuthor && sqlsrv_has_rows($stmtFindAuthor)) {
                        $rowAuthor = sqlsrv_fetch_array($stmtFindAuthor, SQLSRV_FETCH_ASSOC);
                        $authorName = $rowAuthor['AUTHOR_NAME'];
                        $authorlastName = $rowAuthor['AUTHOR_LASTNAME'];
                        echo $authorName . ' ' . $authorlastName;
                    }

                    echo "</td><td>";


                    $sqlFindsupervisorId = "SELECT SUPERVISOR_ID FROM SUPERVISOR_THESIS WHERE THESIS_ID = ?";
                    $paramsFindsupervisorId = array($thesisId);
                    $stmtFindsupervisorId = sqlsrv_query($conn, $sqlFindsupervisorId, $paramsFindsupervisorId);

                    if ($stmtFindsupervisorId && sqlsrv_has_rows($stmtFindsupervisorId)) {
                        $rowsupervisor = sqlsrv_fetch_array($stmtFindsupervisorId, SQLSRV_FETCH_ASSOC);
                        $supervisorId = $rowsupervisor['SUPERVISOR_ID'];
                    }

                    // Supervisor Name
                    $sqlFindSupervisor = "SELECT SUPERVISOR_NAME,SUPERVISOR_LASTNAME FROM SUPERVISOR WHERE SUPERVISOR_ID = ?";
                    $paramsFindSupervisor = array($supervisorId);
                    $stmtFindSupervisor = sqlsrv_query($conn, $sqlFindSupervisor, $paramsFindSupervisor);

                    if ($stmtFindSupervisor && sqlsrv_has_rows($stmtFindSupervisor)) {
                        $rowSupervisor = sqlsrv_fetch_array($stmtFindSupervisor, SQLSRV_FETCH_ASSOC);
                        $supervisorName = $rowSupervisor['SUPERVISOR_NAME'];
                        $supervisorlastName = $rowSupervisor['SUPERVISOR_LASTNAME'];
                        echo $supervisorName . ' ' . $supervisorlastName;
                    }

                    echo "</td><td>";

                    // Keywords
                    $sqlFindKeywordsId = "SELECT KEYWORDS_ID FROM KEYWORD_THESIS WHERE THESIS_ID = ?";
                    $paramsFindKeywordsId = array($thesisId);
                    $stmtFindKeywordsId = sqlsrv_query($conn, $sqlFindKeywordsId, $paramsFindKeywordsId);

                    $keywords = array(); // Keyword'leri saklamak için boþ bir dizi oluþturuyoruz.

                    if ($stmtFindKeywordsId && sqlsrv_has_rows($stmtFindKeywordsId)) {
                        while ($rowKeyword = sqlsrv_fetch_array($stmtFindKeywordsId, SQLSRV_FETCH_ASSOC)) {
                            $keywords[] = $rowKeyword['KEYWORDS_ID']; // Keyword ID'yi diziye ekliyoruz.
                        }
                    }

                    // Her bir keyword için ayrý bir sorgu yaparak sonuçlarý ekrana yazýyoruz.
                    foreach ($keywords as $keywordId) {
                        $sqlFindKeywords = "SELECT KEYWORD FROM KEYWORDS WHERE KEYWORDS_ID = ?";
                        $paramsFindKeywords = array($keywordId);
                        $stmtFindKeywords = sqlsrv_query($conn, $sqlFindKeywords, $paramsFindKeywords);

                        if ($stmtFindKeywords && sqlsrv_has_rows($stmtFindKeywords)) {
                            $rowKeyword = sqlsrv_fetch_array($stmtFindKeywords, SQLSRV_FETCH_ASSOC);
                            $keyword = $rowKeyword['KEYWORD'];
                            echo $keyword . "<br>"; // Her bir keyword'i yeni bir satýrda gösteriyoruz.
                        }
                    }

                    echo "</td><td>";

                    // Topics
                    $sqlFindTopicsId = "SELECT TOPICS_ID FROM THESIS_TOPICS WHERE THESIS_ID = ?";
                    $paramsFindTopicsId = array($thesisId);
                    $stmtFindTopicsId = sqlsrv_query($conn, $sqlFindTopicsId, $paramsFindTopicsId);

                    if ($stmtFindTopicsId && sqlsrv_has_rows($stmtFindTopicsId)) {
                        $rowTopics = sqlsrv_fetch_array($stmtFindTopicsId, SQLSRV_FETCH_ASSOC);
                        $TopicsId = $rowTopics['TOPICS_ID'];
                    }

                    $sqlFindTopics = "SELECT TOPICS_NAME FROM TOPICS WHERE TOPICS_ID = ?";
                    $paramsFindTopics = array($TopicsId);
                    $stmtFindTopics = sqlsrv_query($conn, $sqlFindTopics, $paramsFindTopics);

                    if ($stmtFindTopics && sqlsrv_has_rows($stmtFindTopics)) {
                        $rowTopics = sqlsrv_fetch_array($stmtFindTopics, SQLSRV_FETCH_ASSOC);
                        $Topics = $rowTopics['TOPICS_NAME'];

                        echo $Topics;
                    }

                    echo "</td><tr>";
                }
            
        }
        echo "</table>";




    } else {
        echo "Veri bulunamadý.";
    }
    }

    else if ($searchField === "SUPERVISOR_NAME") {
    // Kullanýcýdan alýnan isim-soyisim deðerini boþluk karakterine göre ayýrma
    $supervisorFullName = $searchTerm;
    $supervisorNameParts = explode(' ', $supervisorFullName);

    if (count($supervisorNameParts) > 1) {
        $supervisorName = $supervisorNameParts[0];
        $supervisorLastName = $supervisorNameParts[1];
    } else {
        $supervisorName = $supervisorFullName;
        $supervisorLastName = null; // Eðer sadece isim verilmiþse soyisimi kontrol etme
    }

    // Supervisor Name ve Supervisor Lastname deðerlerini kontrol etmek üzere sorgu oluþturma
    if ($supervisorLastName !== null) {
        // Eðer soyisim varsa hem isim hem soyisim üzerinden sorgu yap
        $sqlFindSupervisorId = "SELECT SUPERVISOR_ID FROM SUPERVISOR WHERE SUPERVISOR_NAME = ? AND SUPERVISOR_LASTNAME = ?";
        $paramsFindSupervisorId = array($supervisorName, $supervisorLastName);
    } else {
        // Eðer sadece isim varsa sadece isim üzerinden sorgu yap
        $sqlFindSupervisorId = "SELECT SUPERVISOR_ID FROM SUPERVISOR WHERE SUPERVISOR_NAME = ?";
        $paramsFindSupervisorId = array($supervisorName);
    }

    $stmtFindSupervisorId = sqlsrv_query($conn, $sqlFindSupervisorId, $paramsFindSupervisorId);

    if ($stmtFindSupervisorId) {
        echo "<table border='1'>";
        echo "<tr><th>Thesis ID</th><th>Thesis No</th><th>Thesis Title</th><th>Thesis Abstract</th><th>Thesis Year</th><th>Thesis Type</th><th>Submission Date</th><th>University</th><th>Institute</th><th>Number of Pages</th><th>Language</th><th>Cosupervisor</th><th>Author</th><th>Supervisor</th><th>Keywords</th><th>Topics</th></tr>";
        while ($row = sqlsrv_fetch_array($stmtFindSupervisorId, SQLSRV_FETCH_ASSOC)) {
            $supervisorId = $row['SUPERVISOR_ID'];

            // Supervisor ID ile ilgili iþlemleri yapabilirsiniz
            $sqlFindsupervisorThesis = "SELECT THESIS_ID FROM SUPERVISOR_THESIS WHERE SUPERVISOR_ID = ?";
            $paramsFindsupervisorThesis = array($supervisorId);
            $stmtFindsupervisorThesis = sqlsrv_query($conn, $sqlFindsupervisorThesis, $paramsFindsupervisorThesis);

            while ($rowThesis = sqlsrv_fetch_array($stmtFindsupervisorThesis, SQLSRV_FETCH_ASSOC)) {
                $thesisId = $rowThesis['THESIS_ID'];

                // Thesis ID ile ilgili iþlemleri yapabilirsiniz
                $sqlFindThesis = "SELECT THESIS_ID, THESIS_NO, THESIS_TITLE, THESIS_ABSTRACT, AUTHOR_ID, THESIS_YEAR, THESIS_TYPE, UNIVERSITY_ID, INSTITUTE_ID, NUMBER_OF_PAGES, LANGUAGE_ID, SUBMISSION_DATE, COSUPERVISOR_ID FROM THESIS WHERE THESIS_ID = ?";
                $paramsFindThesis = array($thesisId);
                $stmtFindThesis = sqlsrv_query($conn, $sqlFindThesis, $paramsFindThesis);

                while ($rowThesisDetails = sqlsrv_fetch_array($stmtFindThesis, SQLSRV_FETCH_ASSOC)) {
                    $thesisId = $rowThesisDetails['THESIS_ID'];
                    $thesisNo = $rowThesisDetails['THESIS_NO'];
                    $thesisTitle = $rowThesisDetails['THESIS_TITLE'];
                    $thesisAbstract = $rowThesisDetails['THESIS_ABSTRACT'];
                    $authorId = $rowThesisDetails['AUTHOR_ID'];
                    $thesisYear = $rowThesisDetails['THESIS_YEAR'];
                    $thesisType = $rowThesisDetails['THESIS_TYPE'];
                    $universityId = $rowThesisDetails['UNIVERSITY_ID'];
                    $instituteId = $rowThesisDetails['INSTITUTE_ID'];
                    $numberofPages = $rowThesisDetails['NUMBER_OF_PAGES'];
                    $languageId = $rowThesisDetails['LANGUAGE_ID'];
                    $submissionDate = $rowThesisDetails['SUBMISSION_DATE'];
                    $cosupervisorId = $rowThesisDetails['COSUPERVISOR_ID'];

                    echo "<tr><td>$thesisId</td><td>$thesisNo</td><td>$thesisTitle</td><td>$thesisAbstract</td><td>$thesisYear</td><td>$thesisType</td><td>" . $submissionDate->format('Y-m-d') . "</td><td>";

                    // University Name
                    $sqlFindUniversity = "SELECT UNIVERSITY_NAME FROM UNIVERSITY WHERE UNIVERSITY_ID = ?";
                    $paramsFindUniversity = array($universityId);
                    $stmtFindUniversity = sqlsrv_query($conn, $sqlFindUniversity, $paramsFindUniversity);

                    if ($stmtFindUniversity && sqlsrv_has_rows($stmtFindUniversity)) {
                        $rowUniversity = sqlsrv_fetch_array($stmtFindUniversity, SQLSRV_FETCH_ASSOC);
                        $universityName = $rowUniversity['UNIVERSITY_NAME'];
                        echo $universityName;
                    }

                    echo "</td><td>";

                    // Institute Name
                    $sqlFindInstitute = "SELECT INSTITUTE_NAME FROM INSTITUTE WHERE INSTITUTE_ID = ?";
                    $paramsFindInstitute = array($instituteId);
                    $stmtFindInstitute = sqlsrv_query($conn, $sqlFindInstitute, $paramsFindInstitute);

                    if ($stmtFindInstitute && sqlsrv_has_rows($stmtFindInstitute)) {
                        $rowInstitute = sqlsrv_fetch_array($stmtFindInstitute, SQLSRV_FETCH_ASSOC);
                        $instituteName = $rowInstitute['INSTITUTE_NAME'];
                        echo $instituteName;
                    }

                    echo "</td><td>$numberofPages</td><td>";

                    // Language Name
                    $sqlFindLanguage = "SELECT LANGUAGE_NAME FROM LANGUAGE WHERE LANGUAGE_ID = ?";
                    $paramsFindLanguage = array($languageId);
                    $stmtFindLanguage = sqlsrv_query($conn, $sqlFindLanguage, $paramsFindLanguage);

                    if ($stmtFindLanguage && sqlsrv_has_rows($stmtFindLanguage)) {
                        $rowLanguage = sqlsrv_fetch_array($stmtFindLanguage, SQLSRV_FETCH_ASSOC);
                        $languageName = $rowLanguage['LANGUAGE_NAME'];
                        echo $languageName;
                    }

                    echo "</td><td>";

                    // Cosupervisor Name
                    $sqlFindCosupervisor = "SELECT COSUPERVISOR_NAME,COSUPERVISOR_LASTNAME FROM COSUPERVISOR WHERE COSUPERVISOR_ID = ?";
                    $paramsFindCosupervisor = array($cosupervisorId);
                    $stmtFindCosupervisor = sqlsrv_query($conn, $sqlFindCosupervisor, $paramsFindCosupervisor);

                    if ($stmtFindCosupervisor && sqlsrv_has_rows($stmtFindCosupervisor)) {
                        $rowCosupervisor = sqlsrv_fetch_array($stmtFindCosupervisor, SQLSRV_FETCH_ASSOC);
                        $cosupervisorName = $rowCosupervisor['COSUPERVISOR_NAME'];
                        $cosupervisorlastName = $rowCosupervisor['COSUPERVISOR_LASTNAME'];
                        echo $cosupervisorName . ' ' . $cosupervisorlastName;
                    }

                    echo "</td><td>";

                    // Author Name
                    $sqlFindAuthor = "SELECT AUTHOR_NAME, AUTHOR_LASTNAME FROM AUTHOR WHERE AUTHOR_ID = ?";
                    $paramsFindAuthor = array($authorId);
                    $stmtFindAuthor = sqlsrv_query($conn, $sqlFindAuthor, $paramsFindAuthor);

                    if ($stmtFindAuthor && sqlsrv_has_rows($stmtFindAuthor)) {
                        $rowAuthor = sqlsrv_fetch_array($stmtFindAuthor, SQLSRV_FETCH_ASSOC);
                        $authorName = $rowAuthor['AUTHOR_NAME'];
                        $authorlastName = $rowAuthor['AUTHOR_LASTNAME'];
                        echo $authorName . ' ' . $authorlastName;
                    }

                    echo "</td><td>";

                    // Supervisor Name
                    $sqlFindSupervisor = "SELECT SUPERVISOR_NAME,SUPERVISOR_LASTNAME FROM SUPERVISOR WHERE SUPERVISOR_ID = ?";
                    $paramsFindSupervisor = array($supervisorId);
                    $stmtFindSupervisor = sqlsrv_query($conn, $sqlFindSupervisor, $paramsFindSupervisor);

                    if ($stmtFindSupervisor && sqlsrv_has_rows($stmtFindSupervisor)) {
                        $rowSupervisor = sqlsrv_fetch_array($stmtFindSupervisor, SQLSRV_FETCH_ASSOC);
                        $supervisorName = $rowSupervisor['SUPERVISOR_NAME'];
                        $supervisorlastName = $rowSupervisor['SUPERVISOR_LASTNAME'];
                        echo $supervisorName . ' ' . $supervisorlastName;
                    }

                    echo "</td><td>";

                    // Keywords
                    $sqlFindKeywordsId = "SELECT KEYWORDS_ID FROM KEYWORD_THESIS WHERE THESIS_ID = ?";
                    $paramsFindKeywordsId = array($thesisId);
                    $stmtFindKeywordsId = sqlsrv_query($conn, $sqlFindKeywordsId, $paramsFindKeywordsId);

                    $keywords = array(); // Keyword'leri saklamak için boþ bir dizi oluþturuyoruz.

                    if ($stmtFindKeywordsId && sqlsrv_has_rows($stmtFindKeywordsId)) {
                        while ($rowKeyword = sqlsrv_fetch_array($stmtFindKeywordsId, SQLSRV_FETCH_ASSOC)) {
                            $keywords[] = $rowKeyword['KEYWORDS_ID']; // Keyword ID'yi diziye ekliyoruz.
                        }
                    }

                    // Her bir keyword için ayrý bir sorgu yaparak sonuçlarý ekrana yazýyoruz.
                    foreach ($keywords as $keywordId) {
                        $sqlFindKeywords = "SELECT KEYWORD FROM KEYWORDS WHERE KEYWORDS_ID = ?";
                        $paramsFindKeywords = array($keywordId);
                        $stmtFindKeywords = sqlsrv_query($conn, $sqlFindKeywords, $paramsFindKeywords);

                        if ($stmtFindKeywords && sqlsrv_has_rows($stmtFindKeywords)) {
                            $rowKeyword = sqlsrv_fetch_array($stmtFindKeywords, SQLSRV_FETCH_ASSOC);
                            $keyword = $rowKeyword['KEYWORD'];
                            echo $keyword . "<br>"; // Her bir keyword'i yeni bir satýrda gösteriyoruz.
                        }
                    }

                    echo "</td><td>";

                    // Topics
                    $sqlFindTopicsId = "SELECT TOPICS_ID FROM THESIS_TOPICS WHERE THESIS_ID = ?";
                    $paramsFindTopicsId = array($thesisId);
                    $stmtFindTopicsId = sqlsrv_query($conn, $sqlFindTopicsId, $paramsFindTopicsId);

                    if ($stmtFindTopicsId && sqlsrv_has_rows($stmtFindTopicsId)) {
                        $rowTopics = sqlsrv_fetch_array($stmtFindTopicsId, SQLSRV_FETCH_ASSOC);
                        $TopicsId = $rowTopics['TOPICS_ID'];
                    }

                    $sqlFindTopics = "SELECT TOPICS_NAME FROM TOPICS WHERE TOPICS_ID = ?";
                    $paramsFindTopics = array($TopicsId);
                    $stmtFindTopics = sqlsrv_query($conn, $sqlFindTopics, $paramsFindTopics);

                    if ($stmtFindTopics && sqlsrv_has_rows($stmtFindTopics)) {
                        $rowTopics = sqlsrv_fetch_array($stmtFindTopics, SQLSRV_FETCH_ASSOC);
                        $Topics = $rowTopics['TOPICS_NAME'];

                        echo $Topics;
                    }

                    echo "</td><tr>";
                }
            }
        }
        echo "</table>";




    } else {
        echo "Veri bulunamadý.";
    }
}


    else if ($searchField === "KEYWORD") {
    // Kullanýcýdan alýnan keyword deðerini boþluk karakterine göre ayýrma
    $keywords = explode(' ', $searchTerm);

    // Her bir keyword için sorgu oluþturma
    $thesisIds = array(); // Tez ID'lerini saklamak için boþ bir dizi oluþturuyoruz.
    $addedThesisIds = array();

    foreach ($keywords as $keyword) {
    $sqlFindKeywordId = "SELECT KEYWORDS_ID FROM KEYWORDS WHERE KEYWORD LIKE ?";
    $paramsFindKeywordId = array("%$keyword%");
    $stmtFindKeywordId = sqlsrv_query($conn, $sqlFindKeywordId, $paramsFindKeywordId);

    if ($stmtFindKeywordId && sqlsrv_has_rows($stmtFindKeywordId)) {
        while ($rowKeyword = sqlsrv_fetch_array($stmtFindKeywordId, SQLSRV_FETCH_ASSOC)) {
            $keywordId = $rowKeyword['KEYWORDS_ID'];

            // Her bir keyword'e ait tezleri bulma
            $sqlFindThesisId = "SELECT THESIS_ID FROM KEYWORD_THESIS WHERE KEYWORDS_ID = ?";
            $paramsFindThesisId = array($keywordId);
            $stmtFindThesisId = sqlsrv_query($conn, $sqlFindThesisId, $paramsFindThesisId);

            if ($stmtFindThesisId && sqlsrv_has_rows($stmtFindThesisId)) {
                while ($rowThesisId = sqlsrv_fetch_array($stmtFindThesisId, SQLSRV_FETCH_ASSOC)) {
                    $addedThesisId = $rowThesisId['THESIS_ID']; // Tez ID'yi deðiþkene atýyoruz.

                    if (!in_array($addedThesisId, $thesisIds)) {
                        $thesisIds[] = $addedThesisId;
                    }
                }
            }
        }
    }
}

    // Elde edilen tez ID'leri üzerinden ana sorgularý yapma
    if (!empty($thesisIds)) {
        echo "<table border='1'>";
        echo "<tr><th>Thesis ID</th><th>Thesis No</th><th>Thesis Title</th><th>Thesis Abstract</th><th>Thesis Year</th><th>Thesis Type</th><th>Submission Date</th><th>University</th><th>Institute</th><th>Number of Pages</th><th>Language</th><th>Cosupervisor</th><th>Author</th><th>Supervisor</th><th>Keywords</th><th>Topics</th></tr>";

        foreach ($thesisIds as $thesisId) {
            $sqlFindThesis = "SELECT THESIS_ID, THESIS_NO, THESIS_TITLE, THESIS_ABSTRACT, AUTHOR_ID, THESIS_YEAR, THESIS_TYPE, UNIVERSITY_ID, INSTITUTE_ID, NUMBER_OF_PAGES, LANGUAGE_ID, SUBMISSION_DATE, COSUPERVISOR_ID FROM THESIS WHERE THESIS_ID = ?";
            $paramsFindThesis = array($thesisId);
            $stmtFindThesis = sqlsrv_query($conn, $sqlFindThesis, $paramsFindThesis);

            while ($rowThesisDetails = sqlsrv_fetch_array($stmtFindThesis, SQLSRV_FETCH_ASSOC)) {
                $thesisId = $rowThesisDetails['THESIS_ID'];
                $thesisNo = $rowThesisDetails['THESIS_NO'];
                $thesisTitle = $rowThesisDetails['THESIS_TITLE'];
                $thesisAbstract = $rowThesisDetails['THESIS_ABSTRACT'];
                $authorId = $rowThesisDetails['AUTHOR_ID'];
                $thesisYear = $rowThesisDetails['THESIS_YEAR'];
                $thesisType = $rowThesisDetails['THESIS_TYPE'];
                $universityId = $rowThesisDetails['UNIVERSITY_ID'];
                $instituteId = $rowThesisDetails['INSTITUTE_ID'];
                $numberofPages = $rowThesisDetails['NUMBER_OF_PAGES'];
                $languageId = $rowThesisDetails['LANGUAGE_ID'];
                $submissionDate = $rowThesisDetails['SUBMISSION_DATE'];
                $cosupervisorId = $rowThesisDetails['COSUPERVISOR_ID'];

                echo "<tr><td>$thesisId</td><td>$thesisNo</td><td>$thesisTitle</td><td>$thesisAbstract</td><td>$thesisYear</td><td>$thesisType</td><td>" . $submissionDate->format('Y-m-d') . "</td><td>";

                // University Name
                $sqlFindUniversity = "SELECT UNIVERSITY_NAME FROM UNIVERSITY WHERE UNIVERSITY_ID = ?";
                $paramsFindUniversity = array($universityId);
                $stmtFindUniversity = sqlsrv_query($conn, $sqlFindUniversity, $paramsFindUniversity);

                if ($stmtFindUniversity && sqlsrv_has_rows($stmtFindUniversity)) {
                    $rowUniversity = sqlsrv_fetch_array($stmtFindUniversity, SQLSRV_FETCH_ASSOC);
                    $universityName = $rowUniversity['UNIVERSITY_NAME'];
                    echo $universityName;
                }

                echo "</td><td>";

                // Institute Name
                $sqlFindInstitute = "SELECT INSTITUTE_NAME FROM INSTITUTE WHERE INSTITUTE_ID = ?";
                $paramsFindInstitute = array($instituteId);
                $stmtFindInstitute = sqlsrv_query($conn, $sqlFindInstitute, $paramsFindInstitute);

                if ($stmtFindInstitute && sqlsrv_has_rows($stmtFindInstitute)) {
                    $rowInstitute = sqlsrv_fetch_array($stmtFindInstitute, SQLSRV_FETCH_ASSOC);
                    $instituteName = $rowInstitute['INSTITUTE_NAME'];
                    echo $instituteName;
                }

                echo "</td><td>$numberofPages</td><td>";

                // Language Name
                $sqlFindLanguage = "SELECT LANGUAGE_NAME FROM LANGUAGE WHERE LANGUAGE_ID = ?";
                $paramsFindLanguage = array($languageId);
                $stmtFindLanguage = sqlsrv_query($conn, $sqlFindLanguage, $paramsFindLanguage);

                if ($stmtFindLanguage && sqlsrv_has_rows($stmtFindLanguage)) {
                    $rowLanguage = sqlsrv_fetch_array($stmtFindLanguage, SQLSRV_FETCH_ASSOC);
                    $languageName = $rowLanguage['LANGUAGE_NAME'];
                    echo $languageName;
                }

                echo "</td><td>";

                // Cosupervisor Name
                $sqlFindCosupervisor = "SELECT COSUPERVISOR_NAME,COSUPERVISOR_LASTNAME FROM COSUPERVISOR WHERE COSUPERVISOR_ID = ?";
                $paramsFindCosupervisor = array($cosupervisorId);
                $stmtFindCosupervisor = sqlsrv_query($conn, $sqlFindCosupervisor, $paramsFindCosupervisor);

                if ($stmtFindCosupervisor && sqlsrv_has_rows($stmtFindCosupervisor)) {
                    $rowCosupervisor = sqlsrv_fetch_array($stmtFindCosupervisor, SQLSRV_FETCH_ASSOC);
                    $cosupervisorName = $rowCosupervisor['COSUPERVISOR_NAME'];
                    $cosupervisorlastName = $rowCosupervisor['COSUPERVISOR_LASTNAME'];
                    echo $cosupervisorName . ' ' . $cosupervisorlastName;
                }

                echo "</td><td>";

                // Author Name
                $sqlFindAuthor = "SELECT AUTHOR_NAME, AUTHOR_LASTNAME FROM AUTHOR WHERE AUTHOR_ID = ?";
                $paramsFindAuthor = array($authorId);
                $stmtFindAuthor = sqlsrv_query($conn, $sqlFindAuthor, $paramsFindAuthor);

                if ($stmtFindAuthor && sqlsrv_has_rows($stmtFindAuthor)) {
                    $rowAuthor = sqlsrv_fetch_array($stmtFindAuthor, SQLSRV_FETCH_ASSOC);
                    $authorName = $rowAuthor['AUTHOR_NAME'];
                    $authorlastName = $rowAuthor['AUTHOR_LASTNAME'];
                    echo $authorName . ' ' . $authorlastName;
                }

                echo "</td><td>";

                // Supervisor Name

                $sqlFindSupervisorId = "SELECT SUPERVISOR_ID FROM SUPERVISOR_THESIS WHERE THESIS_ID = ?";
                $paramsFindSupervisorId = array($thesisId);
                $stmtFindSupervisorId = sqlsrv_query($conn, $sqlFindSupervisorId, $paramsFindSupervisorId);

                if ($stmtFindSupervisorId && sqlsrv_has_rows($stmtFindSupervisorId)) {
                    $rowSupervisorId = sqlsrv_fetch_array($stmtFindSupervisorId, SQLSRV_FETCH_ASSOC);
                    $supervisorId = $rowSupervisorId['SUPERVISOR_ID'];
                }

                $sqlFindSupervisor = "SELECT SUPERVISOR_NAME,SUPERVISOR_LASTNAME FROM SUPERVISOR WHERE SUPERVISOR_ID = ?";
                $paramsFindSupervisor = array($supervisorId);
                $stmtFindSupervisor = sqlsrv_query($conn, $sqlFindSupervisor, $paramsFindSupervisor);

                if ($stmtFindSupervisor && sqlsrv_has_rows($stmtFindSupervisor)) {
                    $rowSupervisor = sqlsrv_fetch_array($stmtFindSupervisor, SQLSRV_FETCH_ASSOC);
                    $supervisorName = $rowSupervisor['SUPERVISOR_NAME'];
                    $supervisorlastName = $rowSupervisor['SUPERVISOR_LASTNAME'];
                    echo $supervisorName . ' ' . $supervisorlastName;
                }

                echo "</td><td>";

                // Keywords
                $sqlFindKeywordsId = "SELECT KEYWORDS_ID FROM KEYWORD_THESIS WHERE THESIS_ID = ?";
                $paramsFindKeywordsId = array($thesisId);
                $stmtFindKeywordsId = sqlsrv_query($conn, $sqlFindKeywordsId, $paramsFindKeywordsId);

                $keywords = array(); // Keyword'leri saklamak için boþ bir dizi oluþturuyoruz.

                if ($stmtFindKeywordsId && sqlsrv_has_rows($stmtFindKeywordsId)) {
                    while ($rowKeyword = sqlsrv_fetch_array($stmtFindKeywordsId, SQLSRV_FETCH_ASSOC)) {
                        $keywords[] = $rowKeyword['KEYWORDS_ID']; // Keyword ID'yi diziye ekliyoruz.
                    }
                }

                // Her bir keyword için ayrý bir sorgu yaparak sonuçlarý ekrana yazýyoruz.
                $keywordString = "";
                foreach ($keywords as $keywordId) {
                    $sqlFindKeywords = "SELECT KEYWORD FROM KEYWORDS WHERE KEYWORDS_ID = ?";
                    $paramsFindKeywords = array($keywordId);
                    $stmtFindKeywords = sqlsrv_query($conn, $sqlFindKeywords, $paramsFindKeywords);

                    if ($stmtFindKeywords && sqlsrv_has_rows($stmtFindKeywords)) {
                        $rowKeyword = sqlsrv_fetch_array($stmtFindKeywords, SQLSRV_FETCH_ASSOC);
                        $keywordString .= $rowKeyword['KEYWORD'] . ", ";
                    }
                }

                // Remove trailing comma and space
                $keywordString = rtrim($keywordString, ", ");

                echo $keywordString;

                echo "</td><td>";

                // Topics
                $sqlFindTopicsId = "SELECT TOPICS_ID FROM THESIS_TOPICS WHERE THESIS_ID = ?";
                $paramsFindTopicsId = array($thesisId);
                $stmtFindTopicsId = sqlsrv_query($conn, $sqlFindTopicsId, $paramsFindTopicsId);

                if ($stmtFindTopicsId && sqlsrv_has_rows($stmtFindTopicsId)) {
                    $rowTopics = sqlsrv_fetch_array($stmtFindTopicsId, SQLSRV_FETCH_ASSOC);
                    $TopicsId = $rowTopics['TOPICS_ID'];
                }

                $sqlFindTopics = "SELECT TOPICS_NAME FROM TOPICS WHERE TOPICS_ID = ?";
                $paramsFindTopics = array($TopicsId);
                $stmtFindTopics = sqlsrv_query($conn, $sqlFindTopics, $paramsFindTopics);

                if ($stmtFindTopics && sqlsrv_has_rows($stmtFindTopics)) {
                    $rowTopics = sqlsrv_fetch_array($stmtFindTopics, SQLSRV_FETCH_ASSOC);
                    $Topics = $rowTopics['TOPICS_NAME'];

                    echo $Topics;
                }

                echo "</td><tr>";
            }
        }
        echo "</table>";
    } else {
        echo "Veri bulunamadý.";
    }
}

    else if ($searchField === "TOPIC") {
    $topics = explode(' ', $searchTerm);

    $thesisIds = array();  // $thesisIds dizisini tanýmlýyoruz

    foreach ($topics as $topic) {
        $sqlFindtopicsId = "SELECT TOPICS_ID FROM TOPICS WHERE TOPICS_NAME LIKE ?";
        $paramsFindtopicsId = array("%$topic%");
        $stmtFindtopicsId = sqlsrv_query($conn, $sqlFindtopicsId, $paramsFindtopicsId);

        if ($stmtFindtopicsId && sqlsrv_has_rows($stmtFindtopicsId)) {
            while ($rowtopics = sqlsrv_fetch_array($stmtFindtopicsId, SQLSRV_FETCH_ASSOC)) {
                $topicsId = $rowtopics['TOPICS_ID'];

                $sqlFindThesisId = "SELECT THESIS_ID FROM THESIS_TOPICS WHERE TOPICS_ID = ?";
                $paramsFindThesisId = array($topicsId);
                $stmtFindThesisId = sqlsrv_query($conn, $sqlFindThesisId, $paramsFindThesisId);

                if ($stmtFindThesisId && sqlsrv_has_rows($stmtFindThesisId)) {
                    while ($rowThesisId = sqlsrv_fetch_array($stmtFindThesisId, SQLSRV_FETCH_ASSOC)) {
                        $addedThesisId = $rowThesisId['THESIS_ID'];

                        if (!in_array($addedThesisId, $thesisIds)) {
                            $thesisIds[] = $addedThesisId;
                        }
                    }
                }
            }
        }
    }


    // Elde edilen tez ID'leri üzerinden ana sorgularý yapma
    if (!empty($thesisIds)) {
        echo "<table border='1'>";
        echo "<tr><th>Thesis ID</th><th>Thesis No</th><th>Thesis Title</th><th>Thesis Abstract</th><th>Thesis Year</th><th>Thesis Type</th><th>Submission Date</th><th>University</th><th>Institute</th><th>Number of Pages</th><th>Language</th><th>Cosupervisor</th><th>Author</th><th>Supervisor</th><th>Keywords</th><th>Topics</th></tr>";

        foreach ($thesisIds as $thesisId) {
            $sqlFindThesis = "SELECT THESIS_ID, THESIS_NO, THESIS_TITLE, THESIS_ABSTRACT, AUTHOR_ID, THESIS_YEAR, THESIS_TYPE, UNIVERSITY_ID, INSTITUTE_ID, NUMBER_OF_PAGES, LANGUAGE_ID, SUBMISSION_DATE, COSUPERVISOR_ID FROM THESIS WHERE THESIS_ID = ?";
            $paramsFindThesis = array($thesisId);
            $stmtFindThesis = sqlsrv_query($conn, $sqlFindThesis, $paramsFindThesis);

            while ($rowThesisDetails = sqlsrv_fetch_array($stmtFindThesis, SQLSRV_FETCH_ASSOC)) {
                $thesisId = $rowThesisDetails['THESIS_ID'];
                $thesisNo = $rowThesisDetails['THESIS_NO'];
                $thesisTitle = $rowThesisDetails['THESIS_TITLE'];
                $thesisAbstract = $rowThesisDetails['THESIS_ABSTRACT'];
                $authorId = $rowThesisDetails['AUTHOR_ID'];
                $thesisYear = $rowThesisDetails['THESIS_YEAR'];
                $thesisType = $rowThesisDetails['THESIS_TYPE'];
                $universityId = $rowThesisDetails['UNIVERSITY_ID'];
                $instituteId = $rowThesisDetails['INSTITUTE_ID'];
                $numberofPages = $rowThesisDetails['NUMBER_OF_PAGES'];
                $languageId = $rowThesisDetails['LANGUAGE_ID'];
                $submissionDate = $rowThesisDetails['SUBMISSION_DATE'];
                $cosupervisorId = $rowThesisDetails['COSUPERVISOR_ID'];

                echo "<tr><td>$thesisId</td><td>$thesisNo</td><td>$thesisTitle</td><td>$thesisAbstract</td><td>$thesisYear</td><td>$thesisType</td><td>" . $submissionDate->format('Y-m-d') . "</td><td>";

                // University Name
                $sqlFindUniversity = "SELECT UNIVERSITY_NAME FROM UNIVERSITY WHERE UNIVERSITY_ID = ?";
                $paramsFindUniversity = array($universityId);
                $stmtFindUniversity = sqlsrv_query($conn, $sqlFindUniversity, $paramsFindUniversity);

                if ($stmtFindUniversity && sqlsrv_has_rows($stmtFindUniversity)) {
                    $rowUniversity = sqlsrv_fetch_array($stmtFindUniversity, SQLSRV_FETCH_ASSOC);
                    $universityName = $rowUniversity['UNIVERSITY_NAME'];
                    echo $universityName;
                }

                echo "</td><td>";

                // Institute Name
                $sqlFindInstitute = "SELECT INSTITUTE_NAME FROM INSTITUTE WHERE INSTITUTE_ID = ?";
                $paramsFindInstitute = array($instituteId);
                $stmtFindInstitute = sqlsrv_query($conn, $sqlFindInstitute, $paramsFindInstitute);

                if ($stmtFindInstitute && sqlsrv_has_rows($stmtFindInstitute)) {
                    $rowInstitute = sqlsrv_fetch_array($stmtFindInstitute, SQLSRV_FETCH_ASSOC);
                    $instituteName = $rowInstitute['INSTITUTE_NAME'];
                    echo $instituteName;
                }

                echo "</td><td>$numberofPages</td><td>";

                // Language Name
                $sqlFindLanguage = "SELECT LANGUAGE_NAME FROM LANGUAGE WHERE LANGUAGE_ID = ?";
                $paramsFindLanguage = array($languageId);
                $stmtFindLanguage = sqlsrv_query($conn, $sqlFindLanguage, $paramsFindLanguage);

                if ($stmtFindLanguage && sqlsrv_has_rows($stmtFindLanguage)) {
                    $rowLanguage = sqlsrv_fetch_array($stmtFindLanguage, SQLSRV_FETCH_ASSOC);
                    $languageName = $rowLanguage['LANGUAGE_NAME'];
                    echo $languageName;
                }

                echo "</td><td>";

                // Cosupervisor Name
                $sqlFindCosupervisor = "SELECT COSUPERVISOR_NAME,COSUPERVISOR_LASTNAME FROM COSUPERVISOR WHERE COSUPERVISOR_ID = ?";
                $paramsFindCosupervisor = array($cosupervisorId);
                $stmtFindCosupervisor = sqlsrv_query($conn, $sqlFindCosupervisor, $paramsFindCosupervisor);

                if ($stmtFindCosupervisor && sqlsrv_has_rows($stmtFindCosupervisor)) {
                    $rowCosupervisor = sqlsrv_fetch_array($stmtFindCosupervisor, SQLSRV_FETCH_ASSOC);
                    $cosupervisorName = $rowCosupervisor['COSUPERVISOR_NAME'];
                    $cosupervisorlastName = $rowCosupervisor['COSUPERVISOR_LASTNAME'];
                    echo $cosupervisorName . ' ' . $cosupervisorlastName;
                }

                echo "</td><td>";

                // Author Name
                $sqlFindAuthor = "SELECT AUTHOR_NAME, AUTHOR_LASTNAME FROM AUTHOR WHERE AUTHOR_ID = ?";
                $paramsFindAuthor = array($authorId);
                $stmtFindAuthor = sqlsrv_query($conn, $sqlFindAuthor, $paramsFindAuthor);

                if ($stmtFindAuthor && sqlsrv_has_rows($stmtFindAuthor)) {
                    $rowAuthor = sqlsrv_fetch_array($stmtFindAuthor, SQLSRV_FETCH_ASSOC);
                    $authorName = $rowAuthor['AUTHOR_NAME'];
                    $authorlastName = $rowAuthor['AUTHOR_LASTNAME'];
                    echo $authorName . ' ' . $authorlastName;
                }

                echo "</td><td>";

                // Supervisor Name

                $sqlFindSupervisorId = "SELECT SUPERVISOR_ID FROM SUPERVISOR_THESIS WHERE THESIS_ID = ?";
                $paramsFindSupervisorId = array($thesisId);
                $stmtFindSupervisorId = sqlsrv_query($conn, $sqlFindSupervisorId, $paramsFindSupervisorId);

                if ($stmtFindSupervisorId && sqlsrv_has_rows($stmtFindSupervisorId)) {
                    $rowSupervisorId = sqlsrv_fetch_array($stmtFindSupervisorId, SQLSRV_FETCH_ASSOC);
                    $supervisorId = $rowSupervisorId['SUPERVISOR_ID'];
                }

                $sqlFindSupervisor = "SELECT SUPERVISOR_NAME,SUPERVISOR_LASTNAME FROM SUPERVISOR WHERE SUPERVISOR_ID = ?";
                $paramsFindSupervisor = array($supervisorId);
                $stmtFindSupervisor = sqlsrv_query($conn, $sqlFindSupervisor, $paramsFindSupervisor);

                if ($stmtFindSupervisor && sqlsrv_has_rows($stmtFindSupervisor)) {
                    $rowSupervisor = sqlsrv_fetch_array($stmtFindSupervisor, SQLSRV_FETCH_ASSOC);
                    $supervisorName = $rowSupervisor['SUPERVISOR_NAME'];
                    $supervisorlastName = $rowSupervisor['SUPERVISOR_LASTNAME'];
                    echo $supervisorName . ' ' . $supervisorlastName;
                }

                echo "</td><td>";

                // Keywords
                $sqlFindKeywordsId = "SELECT KEYWORDS_ID FROM KEYWORD_THESIS WHERE THESIS_ID = ?";
                $paramsFindKeywordsId = array($thesisId);
                $stmtFindKeywordsId = sqlsrv_query($conn, $sqlFindKeywordsId, $paramsFindKeywordsId);

                $keywords = array(); // Keyword'leri saklamak için boþ bir dizi oluþturuyoruz.

                if ($stmtFindKeywordsId && sqlsrv_has_rows($stmtFindKeywordsId)) {
                    while ($rowKeyword = sqlsrv_fetch_array($stmtFindKeywordsId, SQLSRV_FETCH_ASSOC)) {
                        $keywords[] = $rowKeyword['KEYWORDS_ID']; // Keyword ID'yi diziye ekliyoruz.
                    }
                }

                // Her bir keyword için ayrý bir sorgu yaparak sonuçlarý ekrana yazýyoruz.
                $keywordString = "";
                foreach ($keywords as $keywordId) {
                    $sqlFindKeywords = "SELECT KEYWORD FROM KEYWORDS WHERE KEYWORDS_ID = ?";
                    $paramsFindKeywords = array($keywordId);
                    $stmtFindKeywords = sqlsrv_query($conn, $sqlFindKeywords, $paramsFindKeywords);

                    if ($stmtFindKeywords && sqlsrv_has_rows($stmtFindKeywords)) {
                        $rowKeyword = sqlsrv_fetch_array($stmtFindKeywords, SQLSRV_FETCH_ASSOC);
                        $keywordString .= $rowKeyword['KEYWORD'] . ", ";
                    }
                }

                // Remove trailing comma and space
                $keywordString = rtrim($keywordString, ", ");

                echo $keywordString;

                echo "</td><td>";

                // Topics
                $sqlFindTopicsId = "SELECT TOPICS_ID FROM THESIS_TOPICS WHERE THESIS_ID = ?";
                $paramsFindTopicsId = array($thesisId);
                $stmtFindTopicsId = sqlsrv_query($conn, $sqlFindTopicsId, $paramsFindTopicsId);

                if ($stmtFindTopicsId && sqlsrv_has_rows($stmtFindTopicsId)) {
                    $rowTopics = sqlsrv_fetch_array($stmtFindTopicsId, SQLSRV_FETCH_ASSOC);
                    $TopicsId = $rowTopics['TOPICS_ID'];
                }

                $sqlFindTopics = "SELECT TOPICS_NAME FROM TOPICS WHERE TOPICS_ID = ?";
                $paramsFindTopics = array($TopicsId);
                $stmtFindTopics = sqlsrv_query($conn, $sqlFindTopics, $paramsFindTopics);

                if ($stmtFindTopics && sqlsrv_has_rows($stmtFindTopics)) {
                    $rowTopics = sqlsrv_fetch_array($stmtFindTopics, SQLSRV_FETCH_ASSOC);
                    $Topics = $rowTopics['TOPICS_NAME'];

                    echo $Topics;
                }

                echo "</td><tr>";
            }
        }
        echo "</table>";
    } else {
        echo "Veri bulunamadý.";
    }
}







    sqlsrv_close($conn);
} else {
    echo "Veritabaný baðlantýsý baþarýsýz.";
}
?>
