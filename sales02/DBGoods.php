<?php
require_once('db.php');
class DBGoods extends DB{
    //goodsテーブルのCRUD担当
    public function SelectGoodsAll(){
        $sql = "SELECT * FROM goods";
        $res = parent::executeSQL($sql, null);
        $data = "<table class='recordlist' id='goodsTable'>";
        $data .= "<tr><th>ID</th><th>商品</th><th>単価</th><th></th><th></th></tr>\n";
        //echo "b";
        //var_dump($res);
        //exit;
        foreach($row = $res->fetchAll(PDO::FETCH_NUM) as $row){
            $data .= "<tr>";
            for($i=0;$i<count($row);$i++){
                $data .= "<td>{$row[$i]}</td>";
            }
            //更新ボタンのコード
            $data .= <<<eof
            <td><form method='post' action=''>
            <input type='hidden' name='id' value='{$row[0]}'>
            <input type='submit' name='update' value='更新'>
            </form></td>
eof;
            //削除ボタンのコード
            $data .= <<<eof
            <td><form method='post' action=''>
            <input type='hidden' name='id' id='Deletedid' value='{$row[0]}'>
            <input type='submit' name='delete' id='delete' value='削除' onClick='return CheckDelete()'>
            </form></td>
eof;
            $data .= "</tr>\n";
        }
        $data .= "</table>\n";
        return $data;
    }

    public function InsertGoods(){
        $sql = "INSERT INTO goods VALUES(?,?,?)";
        $array = array($_POST['GoodsID'],$_POST['Goodsname'],$_POST['Price']);
        parent::executeSQL($sql, $array);
    }

    public function UpdateGoods(){
        $sql = "UPDATE Goods SET Goodsname=?, Price=? WHERE GoodsID=?";
        //array関数の引数の順番に注意する
        $array = array($_POST['Goodsname'],$_POST['Price'],$_POST['GoodsID']);
        parent::executeSQL($sql, $array);
    }

    public function GoodsNameForUpdate($GoodsID){
        return $this->FieldValueForUpdate($GoodsID, "Goodsname");
    }

    public function PriceForUpdate($GoodsID){
        return $this->FieldValueForUpdate($GoodsID, "Price");
    }


    private function FieldValueForUpdate($GoodsID, $field){
        //private関数　上の2つの関数で使用している
        $sql = "SELECT {$field} FROM goods WHERE GoodsID=?";
        $array = array($GoodsID);
        $res = parent::executeSQL($sql, $array);
        $rows = $res->fetch(PDO::FETCH_NUM);
        return $rows[0];
    }

    public function DeleteGoods($GoodsID){
        $sql = "DELETE FROM goods WHERE GoodsID=?";
        $array = array($GoodsID);
        parent::executeSQL($sql, $array);
    }
}

?>