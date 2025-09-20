<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee - EmployeeManager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        :root {
            --primary-navy: #1e3a8a;
            --secondary-gray: #5c9efb;
            --white: #f8fafc;
            --dark-slate: #5c9efb;
            --sidebar-width: 280px;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            --glass: rgba(255, 255, 255, 0.95);
            --danger: #ef4444;
            --success: #22c55e;
            --border-gray: #e5e7eb;
            --text-muted: #5c9efb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--white);
            color: var(--dark-slate);
            line-height: 1.6;
            overflow-x: hidden;
        }

        body.chat-open .chat-window {
            transform: scale(1);
            opacity: 1;
            visibility: visible;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--primary-navy);
            color: var(--white);
            padding: 2rem 1.5rem;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        .sidebar-header i {
            font-size: 2rem;
            margin-right: 0.75rem;
            color: var(--white);
        }

        .sidebar-header h4 {
            font-weight: 600;
            font-size: 1.6rem;
            letter-spacing: 0.5px;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
        }

        .sidebar-nav li {
            margin-bottom: 0.75rem;
        }

        .sidebar-nav a {
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar-nav a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .sidebar-nav a:hover::before,
        .sidebar-nav a.active::before {
            left: 0;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: #5c9efb;
            transform: translateX(5px);
        }

        .sidebar-nav a i {
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        .sidebar-nav a span {
            font-weight: 500;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 3rem;
            min-height: 100vh;
            background: var(--white);
            position: relative;
        }

        .header-bar {
            background: transparent;
            padding: 1rem 2rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position: relative;
            z-index: 1100;
            gap: 0.5rem;
        }

        .profile-btn, .notifications-btn {
            background: var(--primary-navy);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }

        .profile-btn:hover, .notifications-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .chat-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--primary-navy);
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            z-index: 3000;
        }

        .chat-button:hover {
            transform: scale(1.15);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }

        .chat-button i {
            color: var(--white);
            font-size: 2rem;
        }

        .chat-window {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 420px;
            max-height: 80vh;
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            transform: scale(0.95);
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            z-index: 3100;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .chat-window .chat-header {
            background: var(--white);
            color: black;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
            border-bottom: 1px solid var(--border-gray);
        }

        .chat-window .chat-header h5 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .chat-window .close {
            background: transparent;
            color: black;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-window .close:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .chat-window .chat {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
            background: var(--white);
            display: flex;
            flex-direction: column;
            gap: 1rem;
            max-height: calc(80vh - 120px);
        }

        .chat-window .chat .timestamp {
            text-align: center;
            color: black;
            font-size: 0.85rem;
            margin: 0.5rem 0;
        }

        .chat-window .chat .model,
        .chat-window .chat .user,
        .chat-window .chat .error {
            max-width: 85%;
            padding: 0.8rem 1.2rem;
            border-radius: 12px;
            font-size: 1rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            word-wrap: break-word;
        }

        .chat-window .chat .model {
            background: #f0f4f8;
            color: var(--dark-slate);
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }

        .chat-window .chat .user {
            background: #5c9efb;
            color: black;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }

        .chat-window .chat .error {
            background: var(--danger);
            color: var(--white);
            align-self: center;
            text-align: center;
        }

        .chat-window .chat .loader {
            align-self: center;
            width: 30px;
            height: 30px;
            border: 4px solid var(--primary-navy);
            border-top: 4px solid var(--white);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .chat-window .chat .time {
            color: black;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            text-align: right;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .chat-window .input-area {
            padding: 1rem;
            background: var(--white);
            border-bottom-left-radius: 16px;
            border-bottom-right-radius: 16px;
            border-top: 1px solid var(--border-gray);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .chat-window .input-area input {
            width: 80%;
            padding: 0.8rem 1.2rem;
            border: 1px solid var(--border-gray);
            border-radius: 25px;
            font-size: 1rem;
            outline: none;
            background: var(--white);
            transition: all 0.3s ease;
        }

        .chat-window .input-area input:focus {
            border-color: var(--primary-navy);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }

        .chat-window .input-area input::placeholder {
            color: black;
        }

        .chat-window .input-area button {
            display: none;
        }

        /* Responsive Design */
        @media (max-width: 991px) {
            .sidebar {
                width: 80px;
                padding: 1.5rem 0.5rem;
            }

            .sidebar-header h4,
            .sidebar-nav a span {
                display: none;
            }

            .sidebar-nav a {
                justify-content: center;
                padding: 0.6rem;
            }

            .sidebar-nav a i {
                margin-right: 0;
                font-size: 1.4rem;
            }

            .main-content {
                margin-left: 80px;
                padding: 1.5rem;
            }

            .header-bar {
                padding: 0.8rem 1rem;
                margin-bottom: 1.5rem;
                gap: 0.4rem;
            }

            .chat-window {
                width: 380px;
                max-height: 70vh;
            }

            .chat-window .chat {
                max-height: calc(70vh - 120px);
                padding: 1rem;
            }
        }

        @media (max-width: 767px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
                padding: 1rem;
            }

            .sidebar-nav {
                display: flex;
                justify-content: space-around;
            }

            .sidebar-nav li {
                margin-bottom: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .header-bar {
                padding: 0.5rem 1rem;
                margin-bottom: 1rem;
                border-radius: 8px;
                gap: 0.3rem;
            }

            .chat-window {
                width: 100%;
                max-height: 80vh;
                bottom: 0;
                right: 0;
                border-radius: 16px 16px 0 0;
            }

            .chat-window .chat {
                max-height: calc(80vh - 120px);
            }

            .chat-button {
                bottom: 20px;
                right: 20px;
                width: 60px;
                height: 60px;
            }

            .chat-button i {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar animate__animated animate__fadeInLeft">
        <div class="sidebar-header">
            <i class="fas fa-user"></i>
            <h4>Employee Dashboard</h4>
        </div>
        <ul class="sidebar-nav">
            <li><a href="/EMdashboard" class="dashboard"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
            <li><a href="/EMprofile" class="profile"><i class="fas fa-user"></i><span>Profile</span></a></li>
            <li><a href="/EMattendance" class="attendance"><i class="fas fa-calendar"></i><span>My Attendance</span></a></li>
            <li><a href="/employee/leave-requests" class="leaves"><i class="fas fa-calendar-check"></i><span>Request Leave</span></a></li>
            <li><a href="/employee/document-requests" class="documents"><i class="fas fa-file-alt"></i><span>Submit Document</span></a></li>
            <li><a href="/allnewsemp" class="updates"><i class="fas fa-bullhorn"></i><span>News</span></a></li>
            <li><a href="/EMlogs" class="logs"><i class="fas fa-history"></i><span>My Logs</span></a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header-bar">
            <a href="/logout" class="notifications-btn animate__animated animate__fadeIn">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Log Out</span>
                </form>
            </a>
            <a href="/allnewsemp" class="notifications-btn animate__animated animate__fadeIn">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
            </a>
            <a href="/EMprofile" class="profile-btn animate__animated animate__fadeIn">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
        </div>
        @yield('content')
    </div>

    <section class="chat-window">
        <div class="chat-header">
            <h5>Hi, I'm Nato!</h5>
            <button class="close"><i class="fas fa-times"></i></button>
        </div>
        <div class="chat">
            <div class="timestamp">May 19 2025, 6:56 PM</div>
            <div class="model">
                <p>Hi – I am here to help answer any questions you have or direct you to the resources you are looking for. How can I assist you?</p>
                <div class="time">Just now</div>
            </div>
        </div>
        <div class="input-area">
            <input placeholder="Type a message..." type="text">
            <button><i class="fas fa-paper-plane"></i></button>
        </div>
    </section>

    <div class="chat-button animate__animated animate__bounceIn">
        <i class="fas fa-comment"></i>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const businessInfo = `
            App Features
                Employee Management: View and update your profile with details like name, department, and contact information.
                Attendance Tracking: Log and view your attendance records.
                Leave Requests: Submit and manage your leave requests.
                Document Requests: Submit documents for HR approval.
                News Updates: Stay informed with company announcements.
                Privacy & Security: Role-based access control and data encryption ensure secure operations.

            FAQs
            General
            What is EmployeeManager?
            EmployeeManager is a web-based platform for employees to manage their profiles, attendance, leaves, documents, and view company updates.

            Is EmployeeManager free to use?
            The platform is designed for internal company use. Contact your administrator for access details.

            Can I use EmployeeManager offline?
            Most features require an internet connection, but some data may be cached for offline viewing.

            Using the App
            How do I update my profile?
            Navigate to the "Profile" section, edit your details, and save the changes.

            How do I track my attendance?
            Go to the "My Attendance" section to view your attendance records.

            How do I submit a leave request?
            Visit the "Request Leave" section, fill out the request form, and submit it for approval.

            How do I submit a document?
            Go to the "Submit Document" section, upload your document, and submit it.

            How do I view company updates?
            Check the "Updates" section for the latest announcements.

            Security & Access
            Who can access my data?
            Access is restricted based on user roles (e.g., employee, HR). Only authorized users can view or edit your data.

            Is my data secure?
            Yes, we use encryption, secure authentication, and role-based access to protect your data.

            Tone Guidelines
                Conciseness: Provide clear and short responses.
                Formality: Maintain a friendly and professional tone.
                Clarity: Avoid unnecessary technical terms.
                Consistency: Ensure uniform tone and style across responses.

            Example Response:
            "Thank you for your question! You can submit a leave request by navigating to the 'Request Leave' section and filling out the form. Let us know if you need further assistance!"

            Greetings & Small Talk
            User: Hi!
            Bot: Hello! How can I assist you with EmployeeManager today?

            User: Hey, how are you?
            Bot: I'm doing great, thanks! How can I help you today?

            User: Hope you're doing well!
            Bot: Thank you! I'm ready to assist. What's on your mind?

            User: Thank you!
            Bot: You're very welcome! Let me know if you need anything else.

            User: Good morning!
            Bot: Good morning! Ready to tackle your day?

            User: What’s up?
            Bot: Just here to help with your employee tasks! How can I assist?

            User: Bye!
            Bot: See you later! Stay productive! 👋
        `;

        const API_KEY = 'AIzaSyDfJbgtnvGUeTdvsg2Nj_gaGAG74DrBNVI';
        const API_URL = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

        let messages = { history: [] };

        async function sendMessage() {
            const userMessage = document.querySelector(".chat-window input").value.trim();
            if (!userMessage) return;

            try {
                document.querySelector(".chat-window input").value = "";
                document.querySelector(".chat-window .chat").insertAdjacentHTML("beforeend", `
                    <div class="user"><p>${userMessage}</p><div class="time">Just now</div></div>
                `);

                document.querySelector(".chat-window .chat").insertAdjacentHTML("beforeend", `
                    <div class="loader"></div>
                `);

                const payload = {
                    contents: [
                        { role: 'user', parts: [{ text: businessInfo }] },
                        ...messages.history,
                        { role: 'user', parts: [{ text: userMessage }] }
                    ]
                };

                const response = await fetch(`${API_URL}?key=${API_KEY}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                if (!response.ok) throw new Error('Failed to fetch response');

                const data = await response.json();
                const modelMessage = data.candidates[0].content.parts[0].text;

                document.querySelector(".chat-window .chat .loader").remove();
                document.querySelector(".chat-window .chat").insertAdjacentHTML("beforeend", `
                    <div class="model"><p>${modelMessage}</p><div class="time">Just now</div></div>
                `);

                messages.history.push({
                    role: "user",
                    parts: [{ text: userMessage }]
                });
                messages.history.push({
                    role: "model",
                    parts: [{ text: modelMessage }]
                });

                const chat = document.querySelector(".chat-window .chat");
                chat.scrollTop = chat.scrollHeight;
            } catch (error) {
                document.querySelector(".chat-window .chat .loader")?.remove();
                document.querySelector(".chat-window .chat").insertAdjacentHTML("beforeend", `
                    <div class="error"><p>Sorry, something went wrong. Please try again.</p></div>
                `);
            }
        }

        document.querySelector(".chat-window .input-area button").addEventListener("click", sendMessage);
        document.addEventListener("keydown", (e) => {
            if (e.key === 'Enter' && document.body.classList.contains("chat-open")) sendMessage();
            if (e.key === 'Escape') document.body.classList.remove("chat-open");
        });

        document.querySelector(".chat-button").addEventListener("click", () => {
            document.body.classList.toggle("chat-open");
            if (document.body.classList.contains("chat-open")) {
                setTimeout(() => {
                    document.querySelector(".chat-window input").focus();
                }, 300);
            }
        });

        document.querySelector(".chat-window .close").addEventListener("click", () => {
            document.body.classList.remove("chat-open");
        });

        const currentPath = window.location.pathname;
        document.querySelectorAll('.sidebar-nav a').forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });

        document.querySelectorAll('.sidebar-nav a').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.sidebar-nav a').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>