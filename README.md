# Cinema Project - Admin & System Documentation

This document provides a comprehensive guide to the administrative functionalities of the Cinema Project and outlines known system issues that require attention.

---

## **Admin Functionality: Movie Management**

The admin panel allows authorized users to manage the movie catalog, including uploading new movies and scheduling showtimes.

### **How to Upload a Movie**

Follow these steps to add a new movie to the system:

1.  **Access the Admin Panel**: Log in with an administrator account and navigate to the **Movies** section from the sidebar.
2.  **Initiate Creation**: Click the **"Add Movie"** or **"Create New Movie"** button.
3.  **Fill Movie Details**:
    *   **Title**: Enter the full title of the movie (Max 255 characters).
    *   **Genre**: Select the appropriate genre from the dropdown list.
    *   **Release Date**: Specify the official release date.
    *   **Duration**: Enter the movie length in minutes (e.g., 120).
    *   **Description**: Provide a detailed synopsis of the movie.
    *   **YouTube Trailer Link**: (Optional) Paste the full YouTube URL for the movie trailer.
4.  **Upload Poster**:
    *   Select an image file (JPG, PNG, GIF, or WebP).
    *   **Validation**: The file must not exceed **2MB**.
5.  **Configure Cinema & Showtimes**:
    *   **Select Cinemas**: Check the boxes for the cinemas where this movie will be shown.
    *   **Add Showtimes**: Click **"Add Showtime"** to create scheduling rows.
    *   **Hall Selection**: Select a cinema first, then choose an available hall within that cinema.
    *   **Start Time**: Set the date and time for the screening.
    *   **Price**: Set the ticket price for that specific showtime.
6.  **Save**: Click **"Save Movie"** to finalize the upload.

### **Technical Process Flow**
- **Validation**: The system validates all required fields and file constraints.
- **Storage**: The poster image is stored in the `public/posters` directory.
- **Calculation**: Screening end times are automatically calculated by adding the **Duration** to the **Start Time**.
- **Legacy Support**: The first created showtime ID is linked directly to the movie record for backward compatibility.

---

## **Known Issues**

The following issues have been identified and are prioritized for future fixes:

### **1. Cinema & Showtimes Module**
*   **Status**: ⚠️ Buggy / Not Functioning Correctly
*   **Details**: The dynamic association between movies, cinemas, and halls during the upload/edit process is inconsistent. 
*   **Technical Notes**: 
    - The JavaScript logic in [form.blade.php](file:///c:/xampp/htdocs/Cinema-Project/Cinema-Project-PDC03-main/resources/views/admin/movies/form.blade.php) responsible for fetching halls via API may fail or conflict with the `cinema-checkbox` selection.
    - Updating a movie currently deletes all existing showtimes and recreates them, which may cause data integrity issues with existing bookings.

### **2. Analytics Dashboard**
*   **Status**: ⚠️ Static Data
*   **Details**: The analytics dashboard currently displays placeholder/randomized data instead of real-time system metrics.
*   **Technical Notes**: 
    - The [analytics.blade.php](file:///c:/xampp/htdocs/Cinema-Project/Cinema-Project-PDC03-main/resources/views/admin/analytics.blade.php) file uses `Math.random()` and hardcoded arrays in its Chart.js initialization.
    - There is a duplicate `analytics()` method in [AdminController.php](file:///c:/xampp/htdocs/Cinema-Project/Cinema-Project-PDC03-main/app/Http/Controllers/Admin/AdminController.php) (Line 212) that returns the view without passing the calculated KPI data.

### **3. UI/UX Improvements**
*   **Status**: ⚠️ Ongoing
*   **Details**: Multiple pages throughout the application require design refinements to improve consistency, accessibility, and user flow.
*   **Target Areas**: Dashboard layout, form spacing, and mobile responsiveness.

### **4. PayMongo Payment Integration**
*   **Status**: ⚠️ Redirection Bug
*   **Details**: Upon successful payment via PayMongo, users are not consistently redirected to their ticket confirmation page. Instead, they may remain on the payment interface or a generic success page.
*   **Technical Notes**: 
    - The `success_url` passed to PayMongo in [BookingsController.php](file:///c:/xampp/htdocs/Cinema-Project/Cinema-Project-PDC03-main/app/Http/Controllers/BookingsController.php) (Line 133) needs verification.
    - Ensure the `paymentSuccess` method correctly handles the transition to the [bookings.show](file:///c:/xampp/htdocs/Cinema-Project/Cinema-Project-PDC03-main/resources/views/bookings/show.blade.php) view with a clear "Success" state.

---

## **Developer Resources**

*   **Database Schema**: See [migrations](file:///c:/xampp/htdocs/Cinema-Project/Cinema-Project-PDC03-main/database/migrations) for table structures.
*   **Service Layer**: PayMongo logic is encapsulated in [PayMongoService.php](file:///c:/xampp/htdocs/Cinema-Project/Cinema-Project-PDC03-main/app/Services/PayMongoService.php).
*   **Routes**: Admin routes are defined in the `admin` prefix group within [web.php](file:///c:/xampp/htdocs/Cinema-Project/Cinema-Project-PDC03-main/routes/web.php).

---
*Last Updated: 2026-04-28*
