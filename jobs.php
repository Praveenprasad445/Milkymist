<?php
require('top.php');
?>
<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner">
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.php">Home</a>
                                  <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                                  <span class="breadcrumb-item active">Thank You</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- cart-main-area start -->
        <div class="wishlist-area ptb--100 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="wishlist-content">
                           	<div class="col-xs-12">
								<form action="jobaction.php" method="post" enctype="multipart/form-data">
									<div class="single-contact-form">
										<div class="contact-box name">
                                        <label for="fileToUpload">Drop your CV</label>
											<input type="file" name="fileToUpload" id="fileToUpload" style="width:100%">
										</div>
										<span class="field_error" id="login_password_error"></span>
									</div>
                                    <input type="hidden" name="uname" value="<?php $_SESSION['USER_NAME']=$row['name']?>">
									
									<div class="contact-btn">
                                    <input type="submit" value="Upload" name="submit">
									</div>
								</form>
								<div class="form-output login_msg">
									<p class="form-messege field_error"></p>
								</div>
							</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        						
<?php require('footer.php')?>        