<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recetas".
 *
 * @property int $id
 * @property int $id_usuario
 * @property string $tipo
 * @property string $fecha
 * @property int $id_prodp
 * @property string $estado
 * @property string $imagen
 * @property string $titulo
 * @property string $tiempo
 * @property int $comensales
 * @property string $dificultad
 * @property string $ingredientes
 * @property string $pasos
 *
 * @property Favoritos[] $favoritos
 * @property Likes[] $likes
 * @property Producto $prodp
 * @property Usuarios $usuario
 */
class Recetas extends \yii\db\ActiveRecord
{

    public $eventImage;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recetas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'tipo', 'id_prodp', 'estado', 'imagen', 'titulo', 'tiempo', 'comensales', 'dificultad', 'ingredientes', 'pasos'], 'required'],
            [['id_usuario', 'id_prodp', 'comensales'], 'integer'],
            [['fecha', 'ingredientes', 'pasos'], 'safe'],
            [['estado'], 'string'],
            [['tipo', 'dificultad'], 'string', 'max' => 20],
            [['imagen'], 'string', 'max' => 40],
            [['titulo'], 'string', 'max' => 30],
            [['tiempo'], 'string', 'max' => 10],
            [['id'], 'integer'],
            [['id_prodp'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::class, 'targetAttribute' => ['id_prodp' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['id_usuario' => 'id']],
            [['eventImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_usuario' => 'Id Usuario',
            'tipo' => 'Tipo',
            'fecha' => 'Fecha',
            'id_prodp' => 'Id Prodp',
            'estado' => 'Estado',
            'imagen' => 'Imagen',
            'titulo' => 'Titulo',
            'tiempo' => 'Tiempo',
            'comensales' => 'Comensales',
            'dificultad' => 'Dificultad',
            'ingredientes' => 'Ingredientes',
            'pasos' => 'Pasos',
        ];
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Favoritos::class, ['id_receta' => 'id']);
    }

    /**
     * Gets query for [[Likes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Likes::class, ['id_receta' => 'id']);
    }

    /**
     * Gets query for [[Prodp]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProdp()
    {
        return $this->hasOne(Producto::class, ['id' => 'id_prodp']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'id_usuario']);
    }

    public function getNick()
    {
        return Yii::$app->db->createcommand("select nick, imagen from usuarios where id= '$this->id_usuario' ")->queryOne();
    }

    public function getTotallikes()
    {
        return Yii::$app->db->createcommand("select count(*) as total from likes where id_receta= '$this->id' ")->queryOne();
    }

    public function getTotalfavoritos()
    {
        return Yii::$app->db->createcommand("select count(*) as total from favoritos where id_receta= '$this->id' ")->queryOne();
    }

    public function extraFields()
    {
        return ["nick", "totallikes", "totalfavoritos", "likes", "favoritos", "usuario"];
    }

    public function afterFind()
    {
        $this->ingredientes = json_decode($this->ingredientes, true); //Los convertimos desde Json a array de datos
        $this->pasos = json_decode($this->pasos, true); //Los convertimos desde Json a array de datos
        return parent::afterFind();
    }
}
