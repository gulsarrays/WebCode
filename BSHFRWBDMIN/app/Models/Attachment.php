<?php

namespace App\Models;
//eloquent model file
use Illuminate\Database\Eloquent\Model;
/**
 * class attachment to specify attachments table
 * @author user
 *
 */
class Attachment extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attachments';
}
