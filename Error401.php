<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 Unauthorized - Access Denied</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: #333;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }

        .error-card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .error-header {
            background: linear-gradient(to right, #2c3e50, #4a6491);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .error-header h1 {
            font-size: 2.8rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .error-header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .error-content {
            padding: 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .error-icon {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .icon-circle {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            box-shadow: 0 10px 20px rgba(238, 90, 82, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .icon-circle i {
            font-size: 6rem;
            color: white;
        }

        .error-details {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .error-details h2 {
            color: #2c3e50;
            font-size: 1.8rem;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        .error-details p {
            line-height: 1.6;
            margin-bottom: 25px;
            color: #555;
            font-size: 1.1rem;
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        .btn {
            padding: 15px 25px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(to right, #3498db, #2980b9);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #2980b9, #1f639c);
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(52, 152, 219, 0.3);
        }

        .btn-secondary {
            background-color: #f8f9fa;
            color: #495057;
            border: 1px solid #dee2e6;
        }

        .btn-secondary:hover {
            background-color: #e9ecef;
            transform: translateY(-3px);
        }

        .login-form {
            margin-top: 30px;
            padding: 25px;
            background-color: #f8f9fa;
            border-radius: 10px;
            border-left: 5px solid #3498db;
        }

        .login-form h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #495057;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .footer {
            padding: 25px;
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .footer a {
            color: #3498db;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .error-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .error-header h1 {
                font-size: 2.2rem;
                flex-direction: column;
                gap: 10px;
            }
            
            .icon-circle {
                width: 150px;
                height: 150px;
            }
            
            .icon-circle i {
                font-size: 4.5rem;
            }
            
            .error-details h2 {
                font-size: 1.6rem;
            }
            
            .btn {
                padding: 14px 20px;
            }
        }

        @media (max-width: 480px) {
            .error-header {
                padding: 20px;
            }
            
            .error-header h1 {
                font-size: 1.8rem;
            }
            
            .error-content {
                padding: 25px;
            }
            
            .login-form {
                padding: 20px;
            }
            
            .footer {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-card">
            <div class="error-header">
                <h1>
                    <span class="error-code">401</span>
                    <span class="error-title">Unauthorized Access</span>
                </h1>
                <p>You don't have permission to access this page</p>
            </div>
            
            <div class="error-content">
                <div class="error-icon">
                    <div class="icon-circle">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h2>Access Denied</h2>
                </div>
                
                <div class="error-details">
                    <h2>What happened?</h2>
                    <p>You tried to access a page that requires authentication. This could be because:</p>
                    <ul style="padding-left: 20px; margin-bottom: 20px; color: #555;">
                        <li>You are not logged in</li>
                        <li>Your session has expired</li>
                        <li>You don't have the required permissions</li>
                        <li>You provided incorrect credentials</li>
                    </ul>
                    
                </div>
            </div>
            
            <div class="footer">
                <p>If you believe this is an error, please contact your system administrator or <a href="#">support team</a>.</p>
                <p style="margin-top: 5px;">&copy; 2023 Your Company. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script>
        // Simulate login process
        document.getElementById('submitLogin').addEventListener('click', function() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            if (!username || !password) {
                alert('Please enter both username and password');
                return;
            }
            
            // Show loading state
            const btn = document.getElementById('submitLogin');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Authenticating...';
            btn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                // Reset button
                btn.innerHTML = originalText;
                btn.disabled = false;
                
                // In a real scenario, you would check credentials here
                // For demo, just show success message
                alert('Login successful! You will be redirected to the requested page.');
                // In reality, you would redirect or update UI
            }, 1500);
        });
        
        // Make login button focus on form
        document.getElementById('loginBtn').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('username').focus();
        });
        
        // Handle "Return to Homepage" button
        document.querySelectorAll('.btn-secondary')[0].addEventListener('click', function(e) {
            e.preventDefault();
            alert('Redirecting to homepage...');
            // In reality: window.location.href = '/';
        });
        
        // Handle "Go Back" button
        document.querySelectorAll('.btn-secondary')[1].addEventListener('click', function(e) {
            e.preventDefault();
            if (window.history.length > 1) {
                window.history.back();
            } else {
                alert('No previous page in history. Redirecting to homepage...');
                // In reality: window.location.href = '/';
            }
        });
    </script>
</body>
</html>