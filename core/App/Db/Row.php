<?php

abstract class App_Db_Row {
    
    public function __construct($arrData = []) 
    {
        
        foreach ($arrData as $strField => $strValue) {
            $this->$strField = (string) $strValue;
        }
        
    }
    
    public function __get($name)
    {
        return isset($this->$name) ? $this->$name : '';
    }
    
    public function save($bRefresh = false)
    {
        
        $objConnection  = App_Db_Connection::getInstance()->get();
        $objConnection->beginTransaction(); 
        
        $strTableName   = strtolower(get_class($this));
        
        $arrData        = get_object_vars($this);
        
        $arrAvailableFields = $this->_getFields();
        
        $arrBind        = [];
        $arrSqlPart     = [];
        
        foreach ($arrData as $strField => $strValue) {
            if (! in_array($strField, $arrAvailableFields)) {
                continue;
            }
            $arrBind[":$strField"] = $strValue;
            array_push($arrSqlPart, "$strField = :$strField");
        }
        
        if (empty($this->id)) {
            App_Db::write("INSERT $strTableName SET " . implode(", ", $arrSqlPart), $arrBind);
        } else {
            App_Db::write("UPDATE $strTableName SET " . implode(", ", $arrSqlPart) . " WHERE id = :id", $arrBind);
        }
        
        if (empty($this->id)) {
            $this->id   = $objConnection->lastInsertId();
        }
        
        $objConnection->commit();
        
        if ($bRefresh) {

            $arrRow     = App_Db::read("SELECT * FROM $strTableName WHERE id = :id", [
                ":id" => $this->id
            ])->fetch(PDO::FETCH_ASSOC);
            
            foreach ($arrRow as $strField => $strValue) {
                $this->$strField = $strValue;
            }
            
        }
        
        return $this->id;
    }
    
    public function delete()
    {
        
        if (empty($this->id)) {
            return;
        }
        
        $strTableName   = strtolower(get_class($this));
        
        App_Db::write("DELETE FROM $strTableName WHERE id = :id", [
            ':id' => $this->id
        ]);
        
        unset($this);
        
    }
    
    /**
     * 
     * @return array
     */
    protected function _getFields()
    {
        
        $strTableName   = strtolower(get_class($this));
        
        $arrResult      = App_Db::read("SHOW FIELDS FROM $strTableName")->fetchAll(PDO::FETCH_ASSOC);
        
        $arrField       = [];
        
        foreach ($arrResult as $arrRow) {
            array_push($arrField, $arrRow['Field']);
        }
        
        return $arrField;
        
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function toArray()
    {
        
        $arrRow = [];
        foreach ($this->_getFields() as $strField) {
            $arrRow[$strField] = $this->$strField;
        }  
        
        return $arrRow;
    }
    
}
