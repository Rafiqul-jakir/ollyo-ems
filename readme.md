# Event Management System

A simple web-based Event Management System built using pure PHP and MySQL, designed to allow users to create, manage, and view events, as well as register attendees and generate event reports.

## Live Project Link

[Event Management System](http://ollyo.rf.gd)

### Login Credentials for Testing

- **Email:** abc@gmail.com
- **Password:** 1234

---

## Project Overview

### Objective

The goal of this project is to provide a streamlined platform for event organizers to manage events, register attendees, and access event reports efficiently.

### Core Functionalities

1. **User Authentication:**

   - Secure login and registration using password hashing.

2. **Event Management:**

   - Authenticated users can create, update, view, and delete events.
   - Event details include name and description.

3. **Attendee Registration:**

   - Users can register for events through a form.
   - Registration is capped at the maximum event capacity.

4. **Event Dashboard:**

   - Events are displayed in a paginated, sortable, and filterable format for easy navigation.

5. **Event Reports:**
   - Admins can download attendee lists for specific events in CSV format.

---

## Technical Requirements

- **Backend:** Developed using pure PHP (no frameworks).
- **Database:** MySQL is used for data storage.
- **Validation:** Includes both client-side and server-side validation.
- **Security:** Prepared statements are used to prevent SQL injection.
- **Frontend:** A basic responsive UI built using Bootstrap.

---

## Bonus Features (Optional)

- **Search Functionality:** Search events and attendees easily.
- **AJAX Integration:** Enhanced user experience during event registration.
- **JSON API:** A dedicated API endpoint for fetching event details programmatically.

---

## Installation and Setup Instructions

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/Rafiqul-jakir/ollyo-ems
   ```
