Process Flow
1. Admin Setup

Login: Log in as admin@example.com.
Create Event: Create a new event (name, date, information).
Dynamic Form: Set which questions should be in the form for the event (e.g., name, company, email).
Quotas: Define how many seats are available for each role (e.g., 50 for Employee, 20 for External).
Approval Bands: Define who should approve the registrations (e.g., Level 1: Manager, Level 2: Director).

2. User Registration

Login: Log in as emp1@example.com or guest@example.com.
Register: Go to 'Upcoming Events', select the event, and fill out the form.
Waitlist: If the event quota is full, the user gets the option to join the 'Waitlist'.

3. Approval Process

Login: Log in as manager@example.com or director@example.com.
Dashboard: A list of pending applications will be visible on the dashboard.
Action: The approver can view the application details (View Details) and choose to 'Approve' or 'Reject'.
Flow: If there are multiple levels (e.g., first Manager, then Director), the application moves to the Director only after the Manager approves it.

⚙️ Technical Logic
Dynamic Forms
The admin can create different form fields (Text, Email, Number, Dropdown) for each event. During registration, the server validates according to these fields and saves the data in JSON format.
Quota Logic
Each event has separate quotas per role. Both 'Pending' and 'Approved' applications are counted toward the quota.
Approval Bands
The admin defines the approval sequence. If no approval bands are set for the event, the registration is automatically marked as Approved.