<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--print error messages-->
<?php if ($this->session->flashdata('errors')): ?>
     <div class="alert alert-danger alert-dismissible">

        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

        <span>
            <i class="icon fa fa-ban"></i> 
            <?php echo $this->session->flashdata('errors'); ?>
            <?php $this->session->unmark_flash('errors'); ?>
        </span>


    </div>
<?php endif; ?>

<!--print custom error message-->
<?php if ($this->session->flashdata('error')): ?>

    <div class="alert alert-danger alert-dismissible">

        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

        <span>
            <i class="icon fa fa-ban"></i> 
            <?php echo $this->session->flashdata('error'); ?>
            <?php $this->session->unmark_flash('error'); ?>
        </span>


    </div>
<!--print custom success message-->
<?php elseif ($this->session->flashdata('success')): ?>

    <div class="alert alert-success alert-dismissible">

        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

        <span>
            <i class="icon fa fa-check"></i> 
            <?php echo $this->session->flashdata('success'); ?>
            <?php $this->session->unmark_flash('success'); ?>
        </span>


    </div>

<?php endif; ?>
