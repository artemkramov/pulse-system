<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "postlang".
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $language
 * @property string $title
 * @property string $content
 *
 * @property Post $post
 */
class PostLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'postlang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'language', 'title', 'content'], 'required'],
            [['post_id'], 'integer'],
            [['content'], 'string'],
            [['language'], 'string', 'max' => 6],
            [['title'], 'string', 'max' => 255],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'post_id'  => 'Post ID',
            'language' => 'Language',
            'title'    => 'Title',
            'content'  => 'Content',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
}
