// Main JavaScript File
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebar = document.getElementById('sidebar');
    
    if (mobileMenuToggle && sidebar) {
        mobileMenuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            mobileMenuToggle.innerHTML = sidebar.classList.contains('active') 
                ? '<i class="fas fa-times"></i>' 
                : '<i class="fas fa-bars"></i>';
        });
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(event.target) && 
                    !mobileMenuToggle.contains(event.target) && 
                    sidebar.classList.contains('active')) {
                    sidebar.classList.remove('active');
                    mobileMenuToggle.innerHTML = '<i class="fas fa-bars"></i>';
                }
            }
        });
    }
    
    // Update active link in sidebar
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.sidebar-nav a');
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPage || 
            (href === 'dashboard.html' && currentPage === '') ||
            (href.includes(currentPage) && currentPage !== '')) {
            link.classList.add('active');
        }
    });
    
    // Initialize tooltips
    const tooltips = document.querySelectorAll('[data-toggle="tooltip"]');
    tooltips.forEach(tooltip => {
        tooltip.addEventListener('mouseenter', function() {
            const title = this.getAttribute('title');
            if (title) {
                const tooltipEl = document.createElement('div');
                tooltipEl.className = 'custom-tooltip';
                tooltipEl.textContent = title;
                document.body.appendChild(tooltipEl);
                
                const rect = this.getBoundingClientRect();
                tooltipEl.style.top = (rect.top - tooltipEl.offsetHeight - 10) + 'px';
                tooltipEl.style.left = (rect.left + rect.width / 2 - tooltipEl.offsetWidth / 2) + 'px';
                
                this.removeAttribute('title');
                this.dataset.originalTitle = title;
            }
        });
        
        tooltip.addEventListener('mouseleave', function() {
            const tooltipEl = document.querySelector('.custom-tooltip');
            if (tooltipEl) {
                tooltipEl.remove();
                if (this.dataset.originalTitle) {
                    this.setAttribute('title', this.dataset.originalTitle);
                }
            }
        });
    });
    
    // Auto-hide alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});

// Utility function for form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.style.borderColor = '#F44336';
            isValid = false;
        } else {
            field.style.borderColor = '';
        }
    });
    
    return isValid;
}

// Utility function for showing notifications
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
        <button class="notification-close">&times;</button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('fade-out');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
    
    // Close button
    notification.querySelector('.notification-close').addEventListener('click', () => {
        notification.classList.add('fade-out');
        setTimeout(() => notification.remove(), 300);
    });
}