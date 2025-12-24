<?php
/**
 * Application received email template
 */
function sendApplicationReceivedEmail($userEmail, $userName, $jobTitle, $companyName) {
    $subject = "Application Received - {$jobTitle} at {$companyName}";
    
    $message = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
            .content { background: #f9fafb; padding: 30px; border-radius: 0 0 10px 10px; }
            .application-info { background: white; padding: 20px; border-radius: 5px; margin: 20px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Application Submitted Successfully!</h1>
            </div>
            <div class='content'>
                <p>Dear {$userName},</p>
                
                <p>Thank you for applying for the position of <strong>{$jobTitle}</strong> at <strong>{$companyName}</strong>.</p>
                
                <div class='application-info'>
                    <h3>Application Details:</h3>
                    <p><strong>Position:</strong> {$jobTitle}</p>
                    <p><strong>Company:</strong> {$companyName}</p>
                    <p><strong>Application Date:</strong> " . date('F j, Y') . "</p>
                    <p><strong>Application ID:</strong> APP-" . strtoupper(uniqid()) . "</p>
                </div>
                
                <h3>What's Next?</h3>
                <ul>
                    <li>The employer will review your application</li>
                    <li>You'll be notified if you're shortlisted for an interview</li>
                    <li>You can track your application status in your dashboard</li>
                </ul>
                
                <p style='margin-top: 30px;'>
                    <a href='https://airigojobs.com/applications.php' style='color: #3b82f6; text-decoration: none; font-weight: bold;'>
                        Track Your Application Status
                    </a>
                </p>
                
                <p>Best of luck with your application!<br>
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