<?php
/**
* Pembautan Query
*/
class QueryBuilder
{
    private $selectables = array();
    private $table;
    private $whereClause;
    private $whereAndClause;
    private $limit;
    private $joinClause;

    /**
    * select table mana saja yang akan ditampilkan
    * jika kosong maka akan select semua
    */
    public static function select($select)
    {
        $this->selectables = func_get_args();

        return $this;
    }

    public function from($table)
    {
        $this->table = $table;

        return $this;
    }

    public function where($where)
    {
        $this->whereClause = $where;

        return $this;
    }

    public function whereAnd($whereAnd)
    {
        $this->whereAndClause = $whereAnd;

        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function join($join)
    {
        $this->joinClause = $join;

        return $this;
    }

    public function result()
    {
        $query[] = "SELECT";
        // if the selectables array is empty, select all
        if (empty($this->selectables)) {
            $query[] = "*";
        }
        // else select according to selectables
        else {
            $query[] = join(', ', $this->selectables);
        }

        $query[] = "FROM";
        $query[] = $this->table;

        if (!empty($this->joinClause)) {
            $query[] = "JOIN";
            $query[] = $this->joinClause;
        }

        if (!empty($this->whereClause)) {
            $query[] = "WHERE";
            $query[] = $this->whereClause;
        }

        if (!empty($this->whereAndClause)) {
            $query[] = "AND";
            $query[] = $this->whereAndClause;
        }

        if (!empty($this->limit)) {
            $query[] = "LIMIT";
            $query[] = $this->limit;
        }

        return join(' ', $query);
    }
}

$qb = new QueryBuilder();
$bukti = "A1";
$qb->select(
    'jurnaldetil.nodetiljurnal',
    'jurnaldetil.noakun',
    'kodeunit.nama',
    'jurnaldetil.tipe',
    'jurnaldetil.jumlah',
    'jurnaldetil.keterangan'
    )
    ->from('jurnaldetil')
    ->join('asds', 'jurnaldetil.unit = kodeunit.unit')
    ->where("jurnaldetil.nobukti = '$bukti'")
    ->whereAnd("jurnaldetil.del = '0'")
    ;
echo $qb->result();
