# Event Management System

## Live Project Link

[ollyo.rf.gd](http://ollyo.rf.gd)

## Login Credentials

- **Email**: abc@gmail.com
- **Password**: 1234

## Project Overview

The **Event Management System** is a web-based platform designed to simplify the process of creating, managing, and viewing events. It allows users to register for events, manage attendee lists, and generate event reports.

### Objective

The goal of this project is to provide a user-friendly system for organizing events, registering attendees, and managing event details. Users can create and manage events, while admins can download reports and monitor registrations.

## Core Functionalities

1. **User Authentication**:

   - Secure user login and registration with hashed passwords.

2. **Event Management**:

   - Authenticated users can create, update, view, and delete events, with details like event name and description.

3. **Attendee Registration**:

   - A registration form that allows attendees to register for events, ensuring the number of registrations does not exceed the event's capacity.

4. **Event Dashboard**:

   - A dashboard displaying events in a sortable, filterable, and paginated format.

5. **Event Reports**:
   - Admins can download attendee lists for specific events in CSV format.

## Technical Requirements

- **Backend**: Pure PHP (no frameworks).
- **Database**: MySQL.
- **Validation**: Both client-side and server-side validation.
- **Security**: Use of prepared statements to prevent SQL injection.
- **UI**: A basic, responsive UI using frameworks like Bootstrap.

## Setup Instructions

1. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/Event-Management-System.git
   ```
