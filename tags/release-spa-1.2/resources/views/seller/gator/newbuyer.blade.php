<style>
.myform {
	display: flex;
	align-items: center;
}

.myform label {
	order: 1;
	width: 16em;
	padding-right: 0.5em;
}

.myform input {
	order: 2;
	flex: 1 1 auto;
	margin-bottom: 0.2em;
}
</style>
<div class="modal fade" id="newbuyer" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">


					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h3 class="text-left">New Merchant</h3>
					</div>
					<div class="modal-footer">


						<div class="col-sm-10">
							<form id="savebuyer" class="form-inline">
								<h3 style="display: flex; padding-left: 7em">Merchant Details</h3>


								<div class="myform">
									<label>Company Name *</label>
									<input class="form-control" type="text" name="company_name">
								</div>


								<div class="myform">

									<label class="">Business Registration No*</label>

									<input class="form-control" type="text" name="br">
								</div>


								<div class="myform">

									<label class="">GST Registration No *</label>

									<input class="form-control" type="text" name="gst">


								</div>

								<!--
								<div class="myform">
									<label >Location</label>

									<input class="form-control" type="text" name="location">
								</div>
								-->

								<div class="myform">
									<label >Address line 1</label>

									<input class="form-control" type="text" name="address1">
								</div>

								<div class="myform">
									<label >Address line 2</label>

									<input class="form-control" type="text" name="address2">
								</div>

								<div class="myform">
									<label >Address line 3</label>

									<input class="form-control" type="text" name="address3">
								</div>

								<div hidden="hidden" class="row single-input form-group5">
									<div class="col-sm-12 col-lg-12">
										<label class="col-sm-4 col-lg-4">Country *</label>
										<div class="col-sm-8 col-lg-8">
											<input class="form-control" type="number" value="150" name="country">
										</div>
									</div>
								</div>


								<div class="myform">
									<label >State *</label>

									<input class="form-control" type="text" value="Wilayah Persekutuan" name="state">
								</div>


								<div class="myform">
									<label >City *</label>

									<input class="form-control" type="text" value="Kuala Lumpur" name="city">

								</div>

								<div class="myform">
									<label >PostCode *</label>

									<input class="form-control" type="text" name="postcode">
								</div>

								<hr>

								<h3 style="display: flex; padding-left: 7em">Contact Person</h3>
								<div class="myform">
									<label >First Name *</label>
									<input class="form-control" type="text" name="fname">

								</div>


								<div class="myform">
									<label >Last Name *</label>

									<input class="form-control" type="text" name="lname">

								</div>

								<div class="myform">
									<label>Designation</label>

									<input class="form-control" type="text" name="designation">

								</div>

								<div class="myform">

									<label>Mobile *</label>

									<input class="form-control" type="text" name="mobile">
								</div>


								<div class="myform">
									<label >Email *</label>

									<input class="form-control" type="text" name="email">
								</div>

								<div class="modal-footer" style="padding-right: 0px">
									<button id="btnsavebuyer" type="button"
									style="border-radius:5px"
									class="btn btn-green">Save</button>
									<!--  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
								</div>
							</form>
						</div>

					</div>

				</div>

			</div>
		</div>
