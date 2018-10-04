<?php

// ----------------------------------------------------------------------------
//
// filesyncdb.class.php - FileSyncDB, ver.0.01 (September 29, 2005)
//
// Description:
//   The class allows to syncronize MySQL INSERT, DELETE and UPDATE simple
//   queries with files, the links of which were stored in database.
//
// Author:
//   Vagharshak Tozalakyan <vagh@armdex.com>
//   This module was written by author on his free time.
//
// Warning:
//   This class is non commercial work. It should not have unexpected results.
//   However, if any damage is caused by this class the author can not be
//   responsible. The use of this class is at the risk of the user.
//
// Requirements:
//   PHP 4, MySQL
//
// ----------------------------------------------------------------------------


class FileSyncDB
{

  // MySQL link identifier.
  var $link_id = '';

  // Root directory (including trialing slash) in which files are stored.
  var $root_dir = '';


  /*
    Description:
      INSERT query extension.
    Prototype:
      resource Insert(string table, array fields, array ext_fields)
    Parameters:
      table - Table name;
      fields - array(<field> => <value>);
      ext_fields - array(<field> => array(<copy from>, <copy to>)).
    Return:
      Resource identifier or FALSE if the query was not executed correctly.
  */
  function Insert($table, $fields, $ext_fields)
  {

    $flds = $vals = '';
    foreach ($fields as $fld=>$val)
    {
      $flds .= $fld . ', ';
      $vals .= '"' . $val . '", ';
    }
    foreach ($ext_fields as $fld=>$info)
    {
      $flds .= $fld . ', ';
      $vals .= '\'' . $info[1] . '\', ';
    }
    if (!empty($flds))
    {
      $flds = substr($flds, 0, -2);
    }
    if (!empty($vals))
    {
      $vals = substr($vals, 0, -2);
    }

    $query = "INSERT INTO $table ($flds) VALUES ($vals)";
    if (!is_resource($this->link_id))
    {
      $result = mysql_query($query);
    }
    else
    {
      $result = mysql_query($query, $this->link_id);
    }
    if (!$result)
    {
      return $result;
    }

    foreach ($ext_fields as $fld=>$info)
    {
      copy($info[0], $this->root_dir . $info[1]);
    }

    return $result;

  }


  /*
    Description:
      DELETE query extension.
    Prototype:
      resource Delete(string table, string where, array ext_fields)
    Parameters:
      table - Table name;
      where - WHERE statement, e.g. 'id=67';
      ext_fields - numeric array of extended field names.
    Return:
      Resource identifier or FALSE if the query was not executed correctly.
  */
  function Delete($table, $where, $ext_fields)
  {

    if (count($ext_fields))
    {
      $flds = implode(', ', $ext_fields);

      $query = "SELECT $flds FROM $table";
      if (!empty($where))
      {
        $query .= " WHERE $where";
      }
      if (!is_resource($this->link_id))
      {
        $result = mysql_query($query);
      }
      else
      {
        $result = mysql_query($query, $this->link_id);
      }
      if (!$result)
      {
        return $result;
      }

      while ($row = mysql_fetch_assoc($result))
      {
        foreach ($ext_fields as $fld)
        {
          unlink($this->root_dir . $row[$fld]);
        }
      }
    }

    $query = "DELETE FROM $table";
    if (!empty($where))
    {
      $query .= " WHERE $where";
    }
    if (!is_resource($this->link_id))
    {
      return mysql_query($query);
    }
    else
    {
      return mysql_query($query, $this->link_id);
    }

  }


  /*
    Description:
      UPDATE query extension.
    Prototype:
      resource Update(string table, string where, array fields, array ext_fields)
    Parameters:
      table - Table name;
      where - WHERE statement, e.g. 'id=67';
      fields - array(<field> => <value>);
      ext_fields - array(<field> => array(<copy from>, <copy to>)).
    Return:
      Resource identifier or FALSE if the query was not executed correctly.
  */
  function Update($table, $where, $fields, $ext_fields)
  {

    $ext_flds = '';
    foreach ($ext_fields as $fld=>$info)
    {
      $ext_flds .= $fld . ', ';
    }
    $del_files = array();
    if (!empty($ext_fields))
    {
      $ext_flds = substr($ext_flds, 0, -2);

      $query = "SELECT $ext_flds FROM $table";
      if (!empty($where))
      {
        $query .= " WHERE $where";
      }
      if (!is_resource($this->link_id))
      {
        $result = mysql_query($query);
      }
      else
      {
        $result = mysql_query($query, $this->link_id);
      }

      if (!$result)
      {
        return $result;
      }

      while ($row = mysql_fetch_assoc($result))
      {
        foreach ($ext_fields as $fld=>$info)
        {
          $del_files[] = $row[$fld];
        }
      }
    }

    $sets = '';
    foreach ($fields as $fld=>$val)
    {
      $sets .= "$fld='$val', ";
    }
    foreach ($ext_fields as $fld=>$info)
    {
      $sets .= "$fld='$info[1]', ";
    }
    if(!empty($sets))
    {
      $sets = substr($sets, 0, -2);
    }

    $query = "UPDATE $table SET $sets";
    if (!empty($where))
    {
      $query .= " WHERE $where";
    }

    if (!is_resource($this->link_id))
    {
      $result = mysql_query($query);
    }
    else
    {
      $result = mysql_query($query, $this->link_id);
    }
    if (!$result)
    {
      return $result;
    }

    foreach($del_files as $file)
    {
      unlink($this->root_dir . $file);
    }

    if (count($del_files))
    {
      foreach($ext_fields as $fld=>$info)
      {
        copy($info[0], $this->root_dir . $info[1]);
      }
    }

    return $result;

  }


}

?>