<div id="register" class="animate form">
            <?php echo validation_errors(); ?>
			<?php echo form_open('admin/login/create_member'); ?>
                <h1> Sign up </h1> 
                <p> 
                    <label for="usernamesignup" class="uname" data-icon="u">Your username</label>
                    <input id="usernamesignup" name="username" required="required" type="text" placeholder="mysuperusername690" />
                </p>
                <p> 
                    <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>
                    <input id="emailsignup" name="email" required="required" type="email" placeholder="mysupermail@mail.com"/> 
                </p>
                <p> 
                    <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
                    <input id="passwordsignup" name="password" required="required" type="password" placeholder="eg. X8df!90EO"/>
                </p>
                <p> 
                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                    <input id="passwordsignup_confirm" name="password_confirm" required="required" type="password" placeholder="eg. X8df!90EO"/>
                </p>
                	<input id="account_type" name="account_type" type="hidden" value="1"/>
                <p class="signin button"> 
                    <input type="submit" value="Sign up"/> 
                </p>
                <p class="change_link">  
                    Already a member ?
                    <a href="#tologin" class="to_register"> Go and log in </a>
                </p>
            </form>
        </div>