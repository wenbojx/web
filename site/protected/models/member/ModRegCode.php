<?php
class ModRegCode extends YDAO
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Fields the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{reg_code}}';
    }
    public function check_code($code){
        if(!$code){
            return false;
        }
        $criteria=new CDbCriteria;
        $criteria->addCondition("code='{$code}'");
        //$criteria->addCondition("state=1");
        return $this->findAll($criteria);
    }
    public function overdue_code($code){
        if(!$code){
            return false;
        }
        $update['state'] = 2;
        $criteria=new CDbCriteria;
        $criteria->addCondition("code='{$code}'");
        return $this->updateAll($update, $criteria);
    }

}