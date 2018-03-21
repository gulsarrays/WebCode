<?php

/*
  Project                     : Oriole
  Module                      : Admin
  File name                   : COREAdminManagerDB.php
  Description                 : Database class for promocode related activities
  Copyright                   : Copyright © 2015, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class COREPromocodeDB
{

    public function __construct()
    {
    }

    /**
     * Function used to get all promocodes details for cms.
     *
     * @param $ConnBean
     *
     * @return array
     */
    public function list_all_promocodes($ConnBean)
    {
        $iResult = array();
        try
        {
            $sQuery = "SELECT p.fldid, p.fldpromocode,p.fldstartdate,p.fldcreateddate,p.fldmodifieddate,p.fldenddate, count(c.fldid) AS count FROM tblpromocode AS p LEFT JOIN tblconsumers AS c ON p.fldid=c.fldpromocodeid WHERE p.fldisdeleted = 0 GROUP BY p.fldpromocode ORDER BY count DESC";
            $ConnBean->getPreparedStatement($sQuery);
            $result = $ConnBean->resultset();
            foreach($result as $promocodedetails)
            {
                $end_date                    = $promocodedetails[DB_COLUMN_FLD_END_DATE];
                $iResult[JSON_TAG_RECORDS][] = array(JSON_TAG_PROMOCODE_ID => $promocodedetails[DB_COLUMN_FLD_ID], JSON_TAG_PROMO_CODE => $promocodedetails[DB_COLUMN_FLD_PROMOCODE], JSON_TAG_CREATED_DATE => $promocodedetails[DB_COLUMN_FLD_CREATED_DATE], JSON_TAG_MODIFIED_DATE => $promocodedetails[DB_COLUMN_FLD_MODIFIED_DATE], JSON_TAG_COUNT => $promocodedetails[JSON_TAG_COUNT], JSON_TAG_START_DATE => $promocodedetails[DB_COLUMN_FLD_START_DATE], JSON_TAG_END_DATE => $end_date);
            }
            if(count($iResult[JSON_TAG_RECORDS]) == 0)
            {
                $iResult[JSON_TAG_STATUS]  = 3;
                $iResult[JSON_TAG_RECORDS] = NULL;
            }
            $iResult[JSON_TAG_STATUS] = 0;
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = 2;
        }

        return $iResult;
    }

    /**
     * Function used to create new promocode.
     *
     * @param  $ConnBean
     * @param  $sPromocode
     * @param  $Startdate
     * @param  $Enddate
     *
     * @return array
     */
    public function createPromocode($ConnBean, $sPromocode, $Startdate, $Enddate)
    {
        $bResult = array();
        try
        {

            $cQuery = "SELECT COUNT(*) promocount, fldisdeleted,fldid FROM tblpromocode WHERE trim(fldpromocode) LIKE :promocode ";
            $ConnBean->getPreparedStatement($cQuery);
            $ConnBean->bind_param(":promocode", $sPromocode);
            $result        = $ConnBean->single();
            $promocount    = $result[JSON_TAG_PROMO_COUNT];
            $ifldisdeleted = $result[DB_COLUMN_FLD_ISDELETED];
            $ifldpromoid   = $result[DB_COLUMN_FLD_ID];
            if($ConnBean->rowCount() && $promocount > 0 && $ifldisdeleted == 0)
            {
                $bResult[JSON_TAG_STATUS] = 1;
            }
            else
            {
                if($ifldisdeleted)
                {
                    $cQuery = "UPDATE tblpromocode SET fldisdeleted = 0   WHERE fldid = :promoid  ";
                    $ConnBean->getPreparedStatement($cQuery);
                    $ConnBean->bind_param(":promoid ", $ifldpromoid);
                    $ConnBean->execute();
                }
                else
                {
                    $sQuery = "INSERT INTO tblpromocode (fldpromocode,fldcreateddate,fldstartdate,fldenddate) VALUES (:promoid,NOW(),:startdate,:enddate)";
                    $ConnBean->getPreparedStatement($sQuery);
                    $ConnBean->bind_param(":promoid", $sPromocode);
                    $ConnBean->bind_param(":startdate", $Startdate);
                    $ConnBean->bind_param(":enddate", $Enddate);
                    $ConnBean->execute();
                    $Promocodeid = $ConnBean->lastInsertId();
                }

                $bResult[JSON_TAG_STATUS]  = 0;
                $bResult[JSON_TAG_RECORDS] = array(JSON_TAG_FLD_ID => $Promocodeid, JSON_TAG_PROMO_CODE => $sPromocode);
            }
        }
        catch(Exception $e)
        {
            $bResult[JSON_TAG_STATUS] = 2;
        }

        return $bResult;
    }

    /**
     * Function used to  update  promocode data in the  database.
     *
     * @param  $ConnBean
     * @param  $sPromocode
     * @param  $Startdate
     * @param  $Enddate
     * @param  $promocodeid
     *
     * @return mixed
     */
    public function edit_promocode($ConnBean, $sPromocode, $Startdate, $Enddate, $promocodeid)
    {

        try
        {

            $sQuery = "UPDATE tblpromocode SET fldpromocode = :promocode,fldstartdate=:startdate,fldenddate=:fldenddate   WHERE fldid = :promocodeid  ";
            $ConnBean->getPreparedStatement($sQuery);

            $ConnBean->bind_param(":promocodeid", $promocodeid);
            $ConnBean->bind_param(":promocode", $sPromocode);
            $ConnBean->bind_param(":startdate", $Startdate);
            $ConnBean->bind_param(":fldenddate", $Enddate);

            $iexec_result = $ConnBean->execute();
            if($iexec_result)
            {
                $iResult[JSON_TAG_STATUS]     = 1;
                $iResult[JSON_TAG_PROMO_CODE] = $sPromocode;
            }
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = 2;
        }

        return $iResult;
    }

    /**
     * Function used to  soft delete  promocode data in the  database.
     *
     * @param  $ConnBean
     * @param  $promocodeid
     *
     * @return mixed
     */
    public function deletePromocode($Promocodeid, $ConnBean)
    {

        $iResult = array();
        try
        {
            $sQuery1 = "SELECT COUNT(*) AS promocode_count FROM tblconsumers WHERE fldpromocodeid = :promocodeid";
            $ConnBean->getPreparedStatement($sQuery1);
            $ConnBean->bind_param(":promocodeid", $Promocodeid);
            $result         = $ConnBean->single();
            $promocodecount = $result[JSON_TAG_PROMOCODE_COUNT];
            if($promocodecount > 0)
            {
                $iResult[JSON_TAG_STATUS] = 1;
            }
            else
            {

                $sQuery = "UPDATE tblpromocode SET fldisdeleted = 1 WHERE fldid= :promocodeid ";
                $ConnBean->getPreparedStatement($sQuery);
                $ConnBean->bind_param(":promocodeid", $Promocodeid);
                $ConnBean->execute();
                $iResult[JSON_TAG_STATUS] = 0;
            }
        }
        catch(Exception $e)
        {
            $iResult[JSON_TAG_STATUS] = 2;
        }

        return $iResult;
    }

    /**
     * Function used to check whether the promo code is valid or not.
     *
     * @param $sPromo_code
     *
     * @return array
     */

    public function valid_promo_code($sPromo_code)
    {
        $ConnBean = new COREDbManager();
        try
        {
            $sQuery = "SELECT *  FROM tblpromocode WHERE fldpromocode = :promocode AND fldisdeleted=0";
            $ConnBean->getPreparedStatement($sQuery);
            $ConnBean->bind_param(':promocode', $sPromo_code);
            $result = $ConnBean->single();
            $today  = date('Y-m-d H:i:s');
            $today  = new DateTime($today);
            if($result)
            {
                $startdate = new DateTime($result[DB_COLUMN_FLD_START_DATE]);
                $enddate   = new DateTime($result[DB_COLUMN_FLD_END_DATE]);
                $enddate->add(new DateInterval('P1D'));
                if(($enddate < $today) || ($startdate > $today))
                {
                    $aResult[JSON_TAG_ERROR] = ERROR_CODE_PROMO_CODE_EXPIRED;
                }
                else
                {

                    $aResult[JSON_TAG_ID]    = $result[JSON_TAG_FLD_ID];
                    $aResult[JSON_TAG_ERROR] = ERRCODE_NO_ERROR;
                }
            }
            else
            {
                $aResult[JSON_TAG_ERROR] = ERROR_CODE_INVALID_PROMO_CODE;
            }
        }
        catch(Exception $e)
        {
            $aResult[JSON_TAG_ERROR] = ERROR_CODE_INVALID_PROMO_CODE;
        }

        return $aResult;
    }
}

?>
