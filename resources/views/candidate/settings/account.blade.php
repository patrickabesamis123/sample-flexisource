<?php 
$baseUrl = "http://previewme.co/";
?>

<!-- TAB 1 -ACCOUNT SETTINGS -->
<div class="pvm-tab-content settings settings--account">
    <article class="pvm-tab-page pvm-fadein pvm-animated" ng-if="tab1">

        <!-- EMAIL ADDRESS -->
        <h1 class="pvm__header settings__header">My Email Address</h1>
        <div class="settings-acct-email-add">
            <div class="setting-acct__alert hidden" id="msg"></div>
            <form class="settings-form clear-float" id="changeEmailForm" ng-submit="changeEmail(data)">
                <div class="flexbox-c-c">
                    <input class="settings-form__input settings-form__input--left" type="text" ng-model="candidateEmail"
                        disabled placeholder="your_current@email.com">
                    <input class="settings-form__input settings-form__input--middle" name="email" placeholder="New Email"
                        type="email" ng-model="data.newEmail" required>
                    <input class="settings-form__input settings-form__input--right" name="email_confirm" placeholder="Confirm New Email"
                        type="email" ng-model="data.confirmEmail" required>
                    <input type="submit" name="action_doNothing" value="Update" class="btn-pvm settings-form__btn-submit"
                        id="email_update">
                </div>
            </form>
        </div>
        <!-- END OF EMAIL ADDRESS -->

        <!-- PASSWORD -->
        <h1 class="pvm__header settings__header">My Password</h1>
        <div class="settings-acct-password">
            <div class="setting-acct__alert" id="msg" style="display:none"></div>
            <form class="settings-form clear-float" id="changePasswordForm" ng-submit="changePassword(data)">
                <div class="flexbox-c-c">
                    <input class="settings-form__input settings-form__input--left" name="current_password" placeholder="Current Password"
                        type="password" ng-model="data.currentPassword" required>
                    <input class="settings-form__input settings-form__input--middle" name="password" placeholder="New Password"
                        type="password" ng-model="data.newPassword" required>
                    <input class="settings-form__input settings-form__input--right" name="confirm_password" placeholder="Confirm New Password"
                        type="password" ng-model="data.confirmPassword" required>
                    <input type="submit" name="action_doNothing" value="Update" class="btn-pvm settings-form__btn-submit"
                        id="Form_action_doNothing">
                </div>
                <a href="/register/forgot_password" class="forgot-password">Forgot your password?</a>
            </form>
        </div>
        <!-- END OF PASSWORD -->

        <!-- PROFILE URL -->
        <h1 class="pvm__header settings__header">My Public Profile URL</h1>
        <div class="settings-acct-public-url rightSetting">
            <p class="settings-acct-public-url__message">
                Enhance your personal brand by creating a custom URL for your PreviewMe profile.<br>
                <span class="note"> Note: You need to adjust your privacy settings to share or make your profile URL
                    public.</span>
            </p>
            <div id="msg_url" style="display:none"></div>
            <div id="WorkHistoryForm" class="animate-show">
                <form id="profileUrlForm" ng-submit="changeProfileUrl(data)">
                    <div class="clear-float">
                        <span class="settings-acct-public-url__left">Current Url: </span>
                        <div class="settings-acct-public-url__right">
                            <a class="settings-acct-public-url__right__link" href="<?php echo $baseUrl ?>me/@{{ profileUrl }}">
                                <?php echo $baseUrl ?>me/@{{ profileUrl }}</a>
                        </div>
                    </div>
                    <div class="clear-float">
                        <span class="settings-acct-public-url__left settings-acct-public-url__left--margin-bot">New
                            URL: </span>
                        <div class="settings-acct-public-url__right">
                            <a class="settings-acct-public-url__right__link" href="javascript:void(0)">
                                <?php echo $baseUrl ?>me/</a>
                            <input class="settings-form__input settings-form__input--url" name="profile_url" id="profile_url"
                                placeholder="New Url" type="text" ng-model="data.new_profile_url" required>
                        </div>
                    </div>
                    <div class="clear-float">
                        <button type="submit" name="action_doNothing" value="Update" class="btn-pvm settings-form__btn-submit"
                            id="profilebtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END OF PROFILE URL -->

        <!-- DISABLE ACCOUNT -->
        <h1 class="pvm__header settings__header">Disable Account</h1>
        <div class="settings-acct-disable clear-float">
            <p class="settings-acct-disable__message">
                By disabling my account I understand that it might take up to 48 hours to delete all my personal info
                from the website.
            </p>
            <button type="submit" name="action_doNothing" confirmed-click="disable_account()" ng-confirm-click="Are you sure you want to disable your account?"
                value="DISABLE MY ACCOUNT" class="btn-pvm settings-acct-disable__btn-disable">DISABLE MY ACCOUNT</button>
        </div>
        <!-- END OF DISABLE ACCOUNT -->

    </article>
</div>
<!-- End TAB 1 -->

@include('candidate.candidate-login-modal')
