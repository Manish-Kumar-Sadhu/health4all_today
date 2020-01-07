<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
    label{
        font-weight:bold;
    }
    .container{
        margin-top:5px;
    }
</style>
<div class="container">
        <?php if(isset($msg)){ ?>
            <div class="alert alert-success" id="alert-success" role="alert"><?php echo $msg;?></div>
        <?php
        }
        ?>
    <div class="card ">
        <div class="card-header bg-primary text-white">
           <h4> Create Question </h4>
        </div>
      <div class="card-body">
      <!-- <?php echo form_open("admin/create_question",array('role'=>'form','class'=>'form-custom' , 'id'=>'create_question')); ?>  -->
      <form id="create_question" action="<?= base_url('admin/create_question') ?>" method="POST">
        <div class="form-group">
            <label for="Question">Question<span class="star" style="color:red"> *</span></label>
            <input type="text" class="form-control" name="question" placeholder="Question" required>
        </div>
<!--         <div class="row">
            <div class="form-group col-md-3">
                <label for="questionImage">Question Image</label>
                <input type="file" class="form-control-file" name="question_image">
            </div>
            <div class="form-group col-md-3" >
                <label for="explanationImage">Explanation Image</label>
                <input type="file" class="form-control-file"  name="explanation_image">
            </div>
            <div class="form-group col-md-4">
                <label for="defaultQuestionId">Default Question ID</label>
                <input type="number" class="form-control" name="default_question_id" placeholder="Enter the default question id">
            </div>
        </div> -->
        <div class="row">
            <div class="form-group col-md-6">
                <label for="levelOfQuestion">Select The Level of Question<span class="star" style="color:red"> *</span></label>
                <select class="form-control" name="question_level" required>
                    <option value="" selected disabled>--Select--</option>
                    <?php
                        foreach($question_levels as $r){ ?>
                        <option value="<?php echo $r->level_id;?>"    
                        <?php if($this->input->post('level') == $r->level_id) echo " selected "; ?>
                        ><?php echo $r->level;?></option>    
                        <?php }  ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="languageId">Select The Language<span class="star" style="color:red"> *</span></label>
                <select class="form-control"  name="language" id="language" required>
                    <option value="" selected disabled>--Select--</option>
                    <?php
                        foreach($languages as $r){ ?>
                        <option value="<?php echo $r->language_id;?>"    
                        <?php if($this->input->post('language') == $r->language_id) echo " selected "; ?>
                        ><?php echo $r->language;?></option>    
                        <?php }  ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="groupId">Select Group <span class="star" style="color:red"> *</span></label>
                <select class="form-control" name="group" id="groupId" required>
                    <option value="" selected disabled>--Select--</option>
                    <?php
                        foreach($groups as $r){
                            echo "<option value='".$r->group_id."'";
                            if($this->input->post('group_name') && $this->input->post('group_name') == $r->group_id) echo " selected ";
                            echo ">".$r->group_name."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="subGroupId">Select Sub Group</label>
                <select class="form-control" name="sub_group" id="subGroupId">
                    <option value="" selected disabled>--Select--</option>
                    <?php
                        foreach($sub_groups as $r){
                            echo "<option value='".$r->sub_group_id."'";
                            if($this->input->post('sub_group') && $this->input->post('sub_group') == $r->sub_group_id) echo " selected ";
                            echo ">".$r->sub_group."</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="explanation">Question Explanation</label>
            <textarea class="form-control" name="question_explanation" rows="2"></textarea>
        </div>
        <label for="answerFields">Answers Options<span class="star" style="color:red"> *</span></label> 
        <label for="answerFields"> (<span style="color:green">&#10004;</span> for the correct option )</label> 
        <div class="wrapper">
            <div class="row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="answer_option[]" required/>
                </div>
                <div class="form-group col-md-2">
                    <input type="hidden" name="correct_option[]" value="0" />
                    <input type="checkbox" id="option_0" name="correct_option[0]" value="1" style="width: 25px;height: 25px;" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="answer_option[]" required/>
                </div>
                <div class="form-group col-md-2">
                    <input type="hidden" name="correct_option[]" value="0" />
                    <input type="checkbox" id="option_1" name="correct_option[1]" value="1"  style="width: 25px;height: 25px;">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-primary add_fields" id="add_fields">+</button>
                </div>
            </div>
        </div>
            <button type="submit" class="btn btn-md btn-primary btn-block" onClick="$(#create_question).reset()">Submit</button>
        </form>
      </div>    
</div>

<script>
    $(function() {

        var wrapper    = $(".wrapper"); //Input fields wrapper
        var add_button = $("#add_fields"); //Add button class or ID
        var x = 2; //Initial input field is set to 1
        //When user click on add input button
        $(add_button).click(function(e){
                e.preventDefault();
                
                $(wrapper).append(`
                    <div class="row">
                        <div class="form-group col-md-6">
                            <input type="text" name="answer_option[]" class="form-control" /> 
                        </div>
                        <div class="form-group col-md-2">
                        <input type="hidden" name="correct_option[]" value="0" />
                        <input type="checkbox" id="option_"${x} name="correct_option[${x}]" value="1" style="width: 25px;height: 25px;">
                        </div>
                        <div class="form-group col-md-1">
                            <button type="button" class="btn btn-danger remove_field">X</button>
                        </div>
                    </div>
                `);
                x++ //input field increment
            });
        
        //when user click on remove button
        $(wrapper).on("click",".remove_field", function(e){ 
            e.preventDefault();
            $(this).parent().parent('div').remove();
            x--; 
        });

});

</script>