<?php $backend_assets=base_url().'backend_assets/'; ?>

<div class="row">

	<div class="col-sm-12">


			<div class="well well-sm">

				<div class="row">

					
					<div class="col-sm-12 col-md-12 col-lg-12">
						<div class="well well-light well-sm no-margin padding-4">

							<div class="row">

							

								<div class="col-sm-12">

									<div class="row">
										<div class="col-sm-12 padding-left-1">
											<h3 class="margin-top-0"><a href="javascript:void(0);"> <?= $task['name']; ?> </a></h3>
											
											<hr>
											<p><?= $task['description']; ?></p>
										</div>
									
									
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-12">
						<!-- data -->
							<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12 padding-left-1">
									<legend>
									Steps To Complete Tasks <a href="javascript:void(0);" class="btn btn-labeled btn-info  pull-right" onclick="openActionOption(this);" id="layerOpt" data-id="show" > <span class="btn-label"><i class="glyphicon glyphicon-plus"></i></span> Layer </a>
									</legend>								
								</div>

								<div class="col-sm-12 col-md-12 col-lg-12 padding-left-1">
									<p class="Show_option" style="display: none;">
										<span class="pull-right" >

										<a href="javascript:void(0);" class="btn btn-labeled btn-info" onclick="openAction('text');" > <span class="btn-label"><i class="fa fa-comment-o"></i></span> Text </a>&nbsp;&nbsp;/&nbsp;&nbsp;
										<a href="javascript:void(0);" class="btn btn-labeled btn-info" onclick="openAction('image');" > <span class="btn-label"><i class="fa fa-file-image-o"></i></span> Image </a>&nbsp;&nbsp;/&nbsp;&nbsp;
										<a href="javascript:void(0);" class="btn btn-labeled btn-info" onclick="openAction('video');" > <span class="btn-label"><i class="fa fa-file-video-o"></i></span> Video </a>
									</span>
										<hr>
									</p>

															
								</div>
								<div class="col-sm-12 col-md-12 col-lg-12">
									<div class="row connectedSortable"  id="sortable1">
										<?php if(!empty($task_meta)): $colors = array('info', 'warning','success'); ?>
											<?php foreach ($task_meta as $sm => $step) { $rand_color = $colors[array_rand($colors)]; ?>
											<div class="col-sm-12 col-md-12 col-lg-12 alert alert-<?= $rand_color; ?> ui-state-default sortlayer" data-metaid="<?= $step->taskmetaId; ?>"data-type="<?= $step->fileType; ?>">
												<?php if($step->fileType=='TEXT'):?>
													<p class="text-muted">
														<?= $step->description; ?> 
															<ul class="list-inline padding-10">
															<li>
															<i class="fa fa-trash"></i>
															<a href="javascript:void(0);" onclick="confirmAction(this);" data-message="You want to Delete this record!" data-id="<?= encoding($step->taskmetaId); ?>" data-url="adminapi/tasks/recordDeleteMeta" data-list="">Delete</a>
															</li>
															<!-- <li>
															<i class="fa fa-comments"></i>
															<a href="javascript:void(0);"> 38 Comments </a>
															</li> -->
															</ul>
													</p>
												<?php endif; ?>
												<?php if($step->fileType=='IMAGE'):?>
													<img width="600" height="400" src="<?= base_url('uploads/task_image/').$step->file; ?>" class="img-responsive"  alt="img">
															<ul class="list-inline padding-10">
																<li>
															<i class="fa fa-trash"></i>
															<a href="javascript:void(0);" onclick="confirmAction(this);" data-message="You want to Delete this record!" data-id="<?= encoding($step->taskmetaId); ?>" data-url="adminapi/tasks/recordDeleteMeta" data-list="">Delete</a>
															</li>
															<!-- <li>
															<i class="fa fa-comments"></i>
															<a href="javascript:void(0);"> 38 Comments </a>
															</li> -->
															</ul>
															
												<?php endif; ?>
												<?php if($step->fileType=='VIDEO'):?>
													<video  width="600" height="400" controls>
													<source src="<?= base_url('uploads/task_video/').$step->file; ?>" type="video/mp4">
													<source src="<?= base_url('uploads/task_video/').$step->file; ?>" type="video/ogg">
													Your browser does not support HTML video.
													</video>
															<ul class="list-inline padding-10">
															<li>
															<i class="fa fa-trash"></i>
															<a href="javascript:void(0);" onclick="confirmAction(this);" data-message="You want to Delete this record!" data-id="<?= encoding($step->taskmetaId); ?>" data-url="adminapi/tasks/recordDeleteMeta" data-list="">Delete</a>
															</li>
															<!-- <li>
															<i class="fa fa-comments"></i>
															<a href="javascript:void(0);"> 38 Comments </a>
															</li> -->
															</ul>
															
												<?php endif; ?>
											</div>
											<?php } ?>
										<?php else: ?>
											<div class="col-sm-12 col-md-12 col-lg-12 text-center">No record fond.</div>
										<?php endif; ?>
									</div>		
								</div>

							</div>
							<!-- end row -->
						<!-- data -->
					</div>
				</div>
			</div>
	</div>
</div>

<!-- END ROW -->
<!-- Modal -->
<div class="modal fade" id="add-data" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">
					Add Step
				</h4>
			</div>
			<div class="modal-body">
	           <!-- Add CUstomer -->
				<!-- widget content -->
				<div class="widget-body no-padding">
					<form action="tasks/addTaskStep" id="create-task-step" class="smart-form" novalidate="novalidate" autocomplete="off">
				
						<fieldset>
						<input type="hidden" name="id" id="taskId" value="<?= encoding($task['taskId']); ?>" >
						<input type="hidden" name="taskstepId" id="taskstepId" value="" >
							

							<div class="col-md-12 col-sm-12 col-lg-12" id="divPro_1">
								
								<section class="col col-md-12">
									<label class="label">TEXT<span class="error">*</span></label>
									<label class="textarea"><i class="icon-append fa fa-comment"></i>
											<textarea rows="4" class="textClassStep" name="textfile_1" placeholder="Enter Task instuctions step" maxlength="400"></textarea>
											<input type="hidden" name="textfileId_1" value="0">
										</label>
								</section>
								
							</div>
							<div class="col-md-12 col-sm-12 col-lg-12" id="divProImg_1">

								<section class="col col-md-12 text-center">
									<label class="label"><strong>Image Preview</strong></label>
									<img width="400" height="300" src="https://via.placeholder.com/640x360.png?text=Image+Preview"  id="blah_1" alt="img">

								</section>
								<section class="col col-md-12">
									<label class="label">Image<span class="error">*</span></label>
									<div class="input input-file">
									<input type="hidden" name="imagefileId_1" value="0">
									<span class="button"><input type="file" class="textClassStep" name="fileImage_1" id="file_1" onchange="readURL(this,1);this.parentNode.nextSibling.value = this.value" accept="image/*">Browse</span><input type="text" readonly="">
									</div>
								</section>
							</div>
							<div class="col-md-12 col-sm-12 col-lg-12" id="divProVideo_1">

								<section class="col col-md-12 text-center">
									<label class="label"><strong>Video Preview</strong></label>
									<div id="privew1"><img  width="400" height="300" src="https://via.placeholder.com/640x360.png?text=Video+Preview"  alt="img"></div>
								</section>
							<section class="col col-md-12">
								<label class="label">Video<span class="error">*</span></label>
								<div class="input input-file">
								<input type="hidden" name="videofileId_1" value="0"><span class="button"><input type="file" class="textClassStep" name="videofile_1" id="videofile_1" onchange="filePreviewMain(this,1);this.parentNode.nextSibling.value = this.value" accept="video/*">Browse</span><input type="text" readonly="">
								</div>
							</section>
							</div>
		</div>
								
								
						</fieldset>

						<footer>
							<button type="submit" id="submit" class="btn btn-primary">
								Save
							</button>
						</footer>
					</form>
				</div>
				<!-- end widget content -->
				<!-- Add CUstomer -->
	        </div>
		</div>
	</div>
</div>
<!-- End modal -->