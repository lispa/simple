<?php
/**
 * Created by PhpStorm.
 * User: Z570
 * Date: 15.12.2019
 * Time: 14:12
 */

namespace Models;
use Models\Avatar;

class User
{
    private $name;
    private $email;
    private $phone;
    private $id;
    private $created_add;
    private $password;
    private $avatar;
    public $permissions = "none";

    function __construct($arFields) {
        $this->name = $arFields["name"];
        $this->email = $arFields["email"];
        $this->phone = $arFields["phone"];
        if(isset($arFields["password"]))
            $this->password = md5($arFields["password"]);
        $this->id = isset($arFields["id"])?$arFields["id"]:null;
        $this->created_add = isset($arFields["created_at"])?$arFields["created_at"]:"";
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCreatedAdd()
    {
        return $this->created_add;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setAvatar($avatarId) {
        $this->avatar = $avatarId;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public static function getByID($id){
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

            $query = "SELECT id, `name`, email, phone, avatar_id, created_at from users WHERE id=".$id;
            if ($result = $mysqli->query($query)) {
                while ($row = $result->fetch_row()) {
                    $arUser["id"] = $row[0];
                    $arUser["name"] = $row[1];
                    $arUser["email"] = $row[2];
                    $arUser["phone"] = $row[3];
                    $arUser["created_at"] = $row[5];
                    $arUser["avatar"] = $row[4];

                    if(!empty($arUser["avatar"])){
                        $arUser["avatar"] = Avatar::getByID($arUser["avatar"]);
                    }
                    $res = $arUser;
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

            $stmt = $mysqli->prepare("UPDATE users SET name=?, email=?, phone=?, avatar_id=? WHERE id=?");
            $stmt->bind_param('sssii',
                $this->name,
                $this->email,
                $this->phone,
                $this->avatar,
                $this->id
            );
        } else {
            $stmt = $mysqli->prepare("INSERT INTO users (`name`, email, password, phone)
VALUES (?,?,?,?)");
            $stmt->bind_param('ssss',
                $this->name,
                $this->email,
                $this->password,
                $this->phone
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

        $query = "DELETE FROM users WHERE id=".$id;

        if ($result = $mysqli->query($query)){
            $res['result'] = true;
            $result->close();
        } else {
            $res['result'] = false;
            $res['error_message'] = $mysqli->error;
        }

        $mysqli->close();
        return $res;
    }
}