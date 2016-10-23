<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Entreprise;

/**
 * EntrepriseSearch represents the model behind the search form about `app\models\Entreprise`.
 */
class EntrepriseSearch extends Entreprise
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status','form_jurid'], 'integer'],
            [['created', 'modified', 'raisonsociale', 'description_small', 'description_big','createdyear'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Entreprise::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created' => $this->created,
            'modified' => $this->modified,
            'status' => $this->status,
            'createdyear' => $this->createdyear,
            'form_jurid' => $this->form_jurid,
        ]);

        $query->andFilterWhere(['like', 'raisonsociale', $this->raisonsociale])
            ->andFilterWhere(['like', 'description_small', $this->description_small])
            ->andFilterWhere(['like', 'description_big', $this->description_big]);

        return $dataProvider;
    }
}
