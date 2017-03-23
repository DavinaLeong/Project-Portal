<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************
	- File Info -
		File name		: generic_delete_modal.php
		Author(s)		: DAVINA Leong Shi Yun
		Date Created	: 01 Feb 2017

	- Contact Info -
		Email	: leong.shi.yun@gmail.com
		Mobile	: (+65) 9369 3752 [Singapore]

***********************************************************************************/
/**
 * @var $delete_modal_header
 * @var $delete_uri
 */
?>
<!-- Delete Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="delete_modal_label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-danger" id="delete_modal_label"><i class="fa fa-exclamation-triangle"></i>&nbsp; <?=$delete_modal_header;?></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert"><strong>This action cannot be undone.</strong></div>
                <p>Do you still want to delete this record?</p>
            </div>
            <div class="modal-footer">
                <a id="delete_btn" class="btn btn-danger" href="<?=site_url($delete_uri);?>">
                    <i class="fa fa-trash-o fa-fw"></i> Delete</a>
                <button id="cancel_delete_btn" type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-ban fa-fw"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>