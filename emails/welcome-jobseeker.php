<?php
/**
 * Welcome email template for job seekers
 */
function sendWelcomeEmailJobSeeker($userEmail, $userName) {
    $subject = "Welcome to Airigojobs - Start Your Career Journey";
    
    $message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
            .button { display: inline-block; background: #3b82f6; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; }
            .steps { margin: 20px 0; }
            .step { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #3b82f6; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Welcome to Airigojobs, {$userName}!</h1>
            </div>
            <div class='content'>
                <p>Thank you for joining Airigojobs, the premier job portal for airline and hospitality professionals.</p>
                
                <div class='steps'>
                    <h3>Get Started in 3 Easy Steps:</h3>
                    <div class='step'>
                        <strong>1. Complete Your Profile</strong><br>
                        Add your experience, skills, and upload your resume to get noticed by employers.
                    </div>
                    <div class='step'>
                        <strong>2. Set Job Preferences</strong><br>
                        Tell us what you're looking for and we'll match you with relevant opportunities.
                    </div>
                    <div class='step'>
                        <strong>3. Apply to Jobs</strong><br>
                        Browse thousands of jobs and apply with just one click.
                    </div>
                </div>
                
                <p style='text-align: center; margin: 30px 0;'>
                    <a href='https://airigojobs.com/profile.php' class='button'>Complete Your Profile</a>
                </p>
                
                <p>Need help getting started? Check out our <a href='https://airigojobs.com/faq.php'>FAQ</a> or <a href='https://airigojobs.com/contact.php'>contact our support team</a>.</p>
                
                <p>Best regards,<br>
                The Airigojobs Team</p>
            </div>
        </div>
    </body>
    </html>";
    
    // Headers for HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Airigojobs <noreply@airigojobs.com>" . "\r\n";
    
    return mail($userEmail, $subject, $message, $headers);
}
?>