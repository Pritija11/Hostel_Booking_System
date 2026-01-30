# Hostel/Rooms Booking System

	A simple and secure Hostel Room Booking System built using PHP, MySQL, HTML, CSS, and JavaScript.
	This project allows public users to view and search available rooms, while admins can manage rooms and view bookings through a protected dashboard.

# Features

	Public Users

	View available hostel rooms

	Search rooms by:

	Room type

	Capacity

	Status

	Book rooms (no dashboard access)

	Admin (Login Required)

	Secure admin login (CSRF protected)

	Admin dashboard

	Manage rooms (Create, Read, Update, Delete)

	View all bookings

	Session-protected routes

# Security Features

	Session-based authentication

	CSRF token protection for:

	Login

	Room create / edit 

	Input sanitization using:

	filter_input()

	htmlspecialchars()

	Prepared statements (PDO) to prevent SQL Injection

	Role-based access control (admin-only routes)

# Tech Stack

	Backend: PHP (Core PHP)

	Database: MySQL

	Frontend: HTML, CSS

	Server: Apache (XAMPP)

	Database Access: PDO

# Project Structure

	Hostel_Booking_System/
	├── assets/
	│   ├── css/
	│   ├── images/
	│   └── js/
	├── auth/
	│   ├── login.php
	│   └── logout.php
	├── config/
	│   ├── csrf.php
	│   ├── db.php
	│   └── session.php
	├── includes/
	│   ├── footer.php
	│   └── header.php
	├── public/
	│   ├── Booking/
	│   ├── Rooms/
	│   ├── dashboard.php
	│   └── index.php
	└── README.md
# Database Overview

	users Table
	 id

	 email 

	 password

	 role

	Rooms Table

	id

	room_type

	capacity

	status

	Bookings Table

	id

	user_id

	room_id

	check_in

	check_out

	created_at

# Admin Access

	Only logged-in admins can:

	Access dashboard

	Manage rooms

	View bookings

	Public users cannot access admin routes directly.

# Admin Access

	Only logged-in admins can:

	Access dashboard

	Manage rooms

	View bookings

	Public users cannot access admin routes directly.

# Future Improvements

	Email confirmation for bookings

	User login for booking history

	Pagination for room listing

# Author

	Pritija Ghising
