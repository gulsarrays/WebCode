

--
-- Updating tblinsights table to update isonline column to 1.
--
UPDATE `tblinsights` SET `fldisonline` = 1 where `fldisdeleted`=0 

