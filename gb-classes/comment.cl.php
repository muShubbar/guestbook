<?php
class Comment
{
    // Properties
    public $linkToDatabase = 'link';
    public $tableName = 'posts';
    public $status = 'y';
    public $theNameErr = '';
    public $theName = '';
    public $theEmail = '';
    public $theEmailErr = '';
    public $theCommentErr = '';
    public $theComment = '';
    public $theDate = '';
    public $resultMessage = '';
    public $decidingMessage = '';
    public $resultPerPage = '10';
    public $numberOfPages = '';
    public $sqlLimitedcomments = array();
    public function setLinkToDatabase($newLinkToDatabase)
    {
        $this->linkToDatabase = $newLinkToDatabase;
    }
    public function setResultPerPage($newResultPerPage)
    {
        $this->resultPerPage = $newResultPerPage;
    }
    public function setTableName($newTableName)
    {
        $this->tableName = $newTableName;
    }
    public function setStatusFlag($newStatusFlag)
    {
        $this->status = $newStatusFlag;
    }
    public function addComment($name, $email, $comment)
    {
        include('gb-includes/magicQuotes.inc.php');
        include('gb-includes/checkInput.inc.php');
        nukeMagicQuotes();
        if (empty($name)) {
            $this->theNameErr = 'الإسم مطلوب';
        } else {
            $this->theName = checkInput($name);
        }
        if (empty($email)) {
            $this->theEmailErr = 'الإيميل مطلوب';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->theEmailErr = 'الرجاء إدخال البريد الألكتروني بشكل صحيح';
        } else {
            $this->theEmail = checkInput($email);
        }
        if (empty($comment)) {
            $this->theCommentErr = 'الرسالة مطلوبة';
        } else {
            $this->theComment = checkInput($comment);
        }
        $this->theDate = date('Y-m-d H:i:s');
        if (empty($this->theNameErr) && empty($this->theEmailErr) && empty($this->theCommentErr)) {
            $sqlInsertSignature = "INSERT INTO `" . $this->tableName ."` (`gb_name`, `gb_email`, `gb_comment`, `gb_approved`, `gb_created`)
                VALUES (:nameplace, :emailplace, :commentplace, 'w', '$this->theDate')";
            $stmt = $this->linkToDatabase->prepare($sqlInsertSignature);
            $stmt->bindParam(':nameplace', $this->theName, PDO::PARAM_STR);
            $stmt->bindParam(':emailplace', $this->theEmail, PDO::PARAM_STR);
            $stmt->bindParam(':commentplace', $this->theComment, PDO::PARAM_STR);
            $stmt->execute();
            $stmt = null;
            $this->resultMessage = 'تم إضافة التعليق بنجاح';
        }
    }
    public function showComments()
    {
        $sqlGetTotal = "SELECT COUNT(*) FROM $this->tableName WHERE gb_approved = \"$this->status\"";
        $resultGetTotal = $this->linkToDatabase->query($sqlGetTotal);
        $numberOfResults = $resultGetTotal->fetchColumn();
        $this->numberOfPages = ceil($numberOfResults/$this->resultPerPage);
        if (!isset($_GET['page'])) {
            $page = 1;
        } else {
                $page = $_GET['page'];
        }
            $thisPageFirstResult = ($page-1)*$this->resultPerPage;
            $sqlShowComments = 'SELECT * FROM ' . $this->tableName . ' 
            WHERE gb_approved = "' . $this->status . '" ORDER BY gb_created DESC LIMIT ' . $thisPageFirstResult . ',' . $this->resultPerPage;
            $this->sqlLimitedcomments = $this->linkToDatabase->query($sqlShowComments);
    }
    public function showResultMessages()
    {
        if (!empty($this->theNameErr)) {
            echo '<p class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> &nbsp;' . $this->theNameErr;
        }
        if (!empty($this->theEmailErr)) {
            echo '<p class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> &nbsp;' . $this->theEmailErr;
        }
        if (!empty($this->theCommentErr)) {
            echo '<p class="alert alert-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> &nbsp;' . $this->theCommentErr;
        }
        if (!empty($this->resultMessage)) {
            echo '<p class="alert alert-success"><i class="fa fa-check-square-o" aria-hidden="true"></i> &nbsp;' . $this->resultMessage . "</p>";
        }
    }
    public function showPaginationLinks($pageSlug)
    {
        echo '<div class="pagination">';
        for ($page=1; $page <= $this->numberOfPages; $page++) {
            $pagActive = '';
            if (isset($_GET['page']) && $page == $_GET['page']) {
                $pagActive = 'class="pageActive"';
            }
            echo '<a href="' . $pageSlug . '?page=' . $page . '" id="pag-item"' . $pagActive .'>' . $page . '</a>';
        }
        echo '</div>';
    }
    public function decideComment($decide)
    {
        if (isset($_GET['gb_id'])) {
            switch ($decide) {
                case 'delete':
                    $sql = "DELETE FROM $this->tableName WHERE gb_id ='" . $_GET['gb_id'] ."'";
                    $result = $this->linkToDatabase->query($sql);
                    if ($result) {
                        $this->decidingMessage = 'تمت عملية الحذف بنجاح';
                    } else {
                        $this->decidingMessage = 'حصل خطأ في عملية الحذف';
                    }
                    break;
                case 'noApprove':
                    $sql = "UPDATE $this->tableName SET gb_approved = 'n' WHERE gb_id ='" . $_GET['gb_id'] ."'";
                    $result = $this->linkToDatabase->query($sql);
                    if ($result) {
                        $this->decidingMessage = 'تمت عملية إلغاء النشر بنجاح';
                    } else {
                        $this->decidingMessage = 'حصل خطأ';
                    }
                    break;
                case 'approve':
                    $sql = "UPDATE $this->tableName SET gb_approved = 'y' WHERE gb_id ='" . $_GET['gb_id'] ."'";
                    $result = $this->linkToDatabase->query($sql);
                    if ($result) {
                        $this->decidingMessage = 'تمت عملية الموافقة بنجاح';
                    } else {
                        $this->decidingMessage = 'حصل خطأ';
                    }
                    break;
                default:
                    $this->decidingMessage = 'حصل خطأ';
            }
        }
    }
}
