<?php
/**
 * Created by PhpStorm.
 * User: Z570
 * Date: 15.12.2019
 * Time: 14:13
 */
namespace Models;

class Avatar
{
    private $id;
    private $user_id;
    private $path;
    private $webpath;
    private $name;

    function __construct($arFields)
    {
        $this->user_id = $arFields['user_id'];
        $this->path = $arFields["file_path"];
        $this->webpath = $arFields["web_path"];
        $this->name = $arFields["file_name"];

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $webpath
     */
    public function setWebpath($webpath)
    {
        $this->webpath = $webpath;
    }

    /**
     * @return mixed
     */
    public function getWebpath()
    {
        return $this->webpath;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public static function getByID($id) {
        $res = false;

        if(!empty($id)){
            // Create connection
            $mysqli = new \mysqli($GLOBALS["db_server"], $GLOBALS["db_user"], $GLOBALS["db_password"], $GLOBALS["db_name"]);
            // Check connection
            if (mysqli_connect_errno()) {
                $res['result'] = false;
                $res['error_message'] = "mysql connection error";
                return $res;
            }

            $query = "SELECT id, `name`, path, webpath from avatars WHERE id=".$id;
            if ($result = $mysqli->query($query)) {
                while ($row = $result->fetch_row()) {
                    $arFile["id"] = $row[0];
                    $arFile["name"] = $row[1];
                    $arFile["path"] = $row[2];
                    $arFile["webpath"] = $row[3];

                    $res = $arFile;
                }
                $result->close();
            } else {
                $res['result'] = false;
                $res['error_message'] = $mysqli->error;
            }

            $mysqli->close();
        }

        return $res;
    }

    public function getByUser($user_id)
    {

    }

    public function save(){
        $res = false;
        // Create connection
        $mysqli = new \mysqli($GLOBALS["db_server"], $GLOBALS["db_user"], $GLOBALS["db_password"], $GLOBALS["db_name"]);
        // Check connection
        if (mysqli_connect_errno()) {
            $res['result'] = false;
            $res['error_message'] = "mysql connection error";
            return $res;
        }

        if(!is_null($this->id)) {
            $stmt = $mysqli->prepare("UPDATE avatars SET name=?, path=?, user_id=? WHERE id=?");
            $stmt->bind_param('sssi',
                $this->name,
                $this->path,
                $this->user_id,
                $this->id
            );
        } else {
            $stmt = $mysqli->prepare("INSERT INTO avatars (`name`, path, user_id, webpath)
VALUES (?,?,?,?)");
            $stmt->bind_param('ssis',
                $this->name,
                $this->path,
                $this->user_id,
                $this->webpath
            );
        }

        if ($stmt->execute() === TRUE) {
            if(is_null($this->id)){
                $res['result'] = true;
                $this->id = mysqli_stmt_insert_id($stmt);
            } else {
                $res['result'] = true;
            }
        } else {
            $res['result'] = false;
            $res['error_message'] = $stmt->error;
        }

        $stmt->close();
        $mysqli->close();

        return $res;
    }

    public function delete($id) {
        $res = false;
        // Create connection
        $mysqli = new \mysqli($GLOBALS["db_server"], $GLOBALS["db_user"], $GLOBALS["db_password"], $GLOBALS["db_name"]);
        // Check connection
        if (mysqli_connect_errno()) {
            $res['result'] = false;
            $res['error_message'] = "mysql connection error";
            return $res;
        }

        $query = "DELETE FROM avatars WHERE id=".$id;

        if ($result = $mysqli->query($query)){
            $res['result'] = true;
            $result->close();

            //todo delete avatar id from user
        } else {
            $res['result'] = false;
            $res['error_message'] = $mysqli->error;
        }

        $mysqli->close();
        return $res;
    }

}