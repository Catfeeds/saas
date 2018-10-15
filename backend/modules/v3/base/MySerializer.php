<?php

namespace backend\modules\v3\base;

class MySerializer extends \yii\rest\Serializer
{
    /**
     * 应app端要求，重写serializeDataProvider方法，加上code=1
     * @param \yii\data\DataProviderInterface $dataProvider
     * @return array|null
     */
    protected function serializeDataProvider($dataProvider)
    {
        if ($this->preserveKeys) {
            $models = $dataProvider->getModels();
        } else {
            $models = array_values($dataProvider->getModels());
        }
        $models = $this->serializeModels($models);

        if (($pagination = $dataProvider->getPagination()) !== false) {
            $this->addPaginationHeaders($pagination);
        }

        if ($this->request->getIsHead()) {
            return null;
        } elseif ($this->collectionEnvelope === null) {
            return $models;
        }

        $result = [
            'code' => 1,
            $this->collectionEnvelope => $models,
        ];
        if ($pagination !== false) {
            return array_merge($result, $this->serializePagination($pagination));
        }

        return $result;
    }
}