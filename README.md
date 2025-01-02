# TRESA Urban Nature Reserve Project 🌿
![image](https://github.com/user-attachments/assets/30717a42-18e9-497f-9010-7d57312c2131)


A comprehensive web system and interactive urban mapping solution developed for TRESA (Totterdown Residents Environmental & Social Action) to manage and visualize urban green spaces and nature reserves.

[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript)
[![Google Maps API](https://img.shields.io/badge/Google_Maps_API-4285F4?style=for-the-badge&logo=google-maps&logoColor=white)](https://developers.google.com/maps)

## 🎯 Project Overview

This project delivers a tailored mapping and data collection system for TRESA, enabling the organization to:
- Track and visualize urban green spaces in Totterdown
- Collect and manage data about private and public nature reserves
- Engage community members in environmental initiatives
- Monitor and analyze the distribution of green spaces

### 🚀 Key Features

- **Interactive Mapping**: Custom Google Maps integration showing public and private green spaces
- **Data Collection**: User-friendly forms for residents to submit their green space information
- **Admin Dashboard**: Comprehensive management system for data verification and analysis
- **Analytics**: Visual representation of green space distribution and statistics
- **Privacy Controls**: Options for anonymous submissions and data protection
- **Feedback System**: Built-in mechanism for user feedback and improvements

## 🛠️ Technical Stack

- **Backend**: PHP 8.1.2
- **Database**: MySQL (MariaDB 10.4.22)
- **Frontend**: HTML5, CSS3, JavaScript
- **Maps Integration**: Google Maps API
- **Visualization**: Chart.js
- **Styling**: Bootstrap 5
- **Version Control**: Git

## 📋 Project Structure

```
tresa-urban-project/
├── admin/                 # Admin dashboard components
├── src/                   # Core application source code
├── formimages/           # User-submitted images storage
├── SRS, PID, Docs/       # Project documentation
└── tresadb.sql          # Database schema and initial data
```

## 💻 Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/tresa-urban-project.git
```

2. Configure your web server (Apache/Nginx) to serve the project directory

3. Set up the database:
```bash
mysql -u root -p < tresadb.sql
```

4. Configure the database connection in `src/config.php`:
```php
$host = 'localhost';
$dbname = 'tresadb';
$username = 'your_username';
$password = 'your_password';
```

5. Install dependencies:
```bash
composer install
```

## 🔧 Configuration

### Required Environment Variables:
- Database credentials
- Google Maps API key
- File upload paths

### Google Maps API Setup:
1. Obtain an API key from Google Cloud Console
2. Enable Maps JavaScript API
3. Add the key to `src/config.php`

## 📱 Features

### For Users
- Submit private green space information
- View interactive map of all green spaces
- Provide feedback
- Access analytics and statistics

### For Administrators
- Verify and manage submissions
- View detailed user data
- Access feedback responses
- Generate reports and analytics

## 🤝 Contributing

We welcome contributions! Please:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Contact

For questions or support, please contact:
- Project Manager: [Your Name](mailto:your.email@example.com)
- TRESA Organization: [suzanne.audrey@btinternet.com](mailto:suzanne.audrey@btinternet.com)

## 🙏 Acknowledgments

- TRESA organization for their collaboration and support
- Totterdown community members for their participation
- Google Maps Platform for mapping capabilities
- All contributors who have helped shape this project

---
⭐️ If you find this project useful, please consider giving it a star!


# Web and Urban Map development for TRESA a Reserve Nature Organization

## Project Poster :
![TRESA POSTER](https://github.com/user-attachments/assets/3828d305-82db-4805-b431-8e7b17ddde98)

### 1.1 Development of a Tailored Mapping Software:
- Design and develop customised mapping software tailored to TRESA's requirements and
the unique characteristics of Totterdown's green spaces.

### 1.2 Enhance Data Collection and Analysis:
- Develop a systematic approach to data collection, including the design of digital forms and
databases for efficient data capture.
- Implement analytical tools to process and analyse collected data, generating valuable
insights into green space usage patterns, environmental factors, and community
preferences.
- Incorporate features such as geospatial visualisation, interactive mapping, and data
overlay capabilities to provide comprehensive information about green space distribution
and accessibility.

### 1.3 Ensure User-Friendly Experience:
- Prioritise user experience in software design, focusing on intuitive interfaces, simplified
workflows, and accessible functionalities to encourage community engagement.
- Conduct user testing and feedback sessions to iteratively refine the software interface and
enhance usability based on user preferences and needs.

### 1.4 Facilitate Sustainable Practices:
- Integrate sustainability principles into the design and development of software features,
promoting eco-friendly behaviours and practices among community members.
- Offer resources and guidance through the software platform to support sustainable
initiatives, such as community gardening, wildlife conservation, and waste reduction
efforts

## Client Sign-off and Feedback:
![TRESA Sign-OFF](https://github.com/user-attachments/assets/9a9729e2-9239-4fbd-b55f-cd029cfbce8c)
