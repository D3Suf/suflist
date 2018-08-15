<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property string $nome
 * @property integer $nome_ceo
 * @property string $ip_company
 * @property integer $n_funcionarios
 * @property integer $h_trabalho_s
 * @property integer $h_inicio
 * @property integer $h_final
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'nome_ceo', 'n_funcionarios', 'h_inicio', 'h_final'], 'required'],
            [['nome_ceo', 'n_funcionarios', 'h_trabalho_s', 'h_inicio', 'h_final'], 'integer'],
            [['nome', 'ip_company'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'nome_ceo' => 'Nome Ceo',
            'ip_company' => 'Ip Company',
            'n_funcionarios' => 'N Funcionarios',
            'h_trabalho_s' => 'H Trabalho S',
            'h_inicio' => 'H Inicio',
            'h_final' => 'H Final',
        ];
    }
}
