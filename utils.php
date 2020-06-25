<?php
    function getLastId($id,$conn)
    {
        $collection = $conn->lab2dev->counters;
        $query = array(
            '_id' => $id
        );
        $result = $collection->find($query)->toArray();
        $where = [ '_id' => $id ];
        $set = [ '$set' => [ 'sequence_value' => $result[0]->sequence_value + 1]];
        $collection->updateOne($where, $set);
        return $result[0]->sequence_value + 1;
    }
?>