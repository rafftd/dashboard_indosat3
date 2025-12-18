// Copy Link Functionality
function copyLink(url) {
    // Create temporary input
    const tempInput = document.createElement('input');
    tempInput.value = url;
    document.body.appendChild(tempInput);
    
    // Select and copy
    tempInput.select();
    tempInput.setSelectionRange(0, 99999); // For mobile devices
    
    try {
        document.execCommand('copy');
        showToast('Link berhasil disalin!', 'success');
    } catch (err) {
        showToast('Gagal menyalin link', 'error');
    }
    
    // Remove temporary input
    document.body.removeChild(tempInput);
}

// Confirm Delete
function confirmDelete(poId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/po/${poId}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Show Answer Modal
function showAnswer(poId) {
    // Fetch answer data via AJAX or show modal
    fetch(`/po/${poId}/answer`)
        .then(response => response.json())
        .then(data => {
            // Show answer in modal or alert
            alert(`Answer for PO #${poId}: ${data.answer}`);
        })
        .catch(error => {
            showToast('Gagal memuat data', 'error');
        });
}

// Toast Notification
function showToast(message, type = 'success') {
    // Remove existing toast if any
    const existingToast = document.querySelector('.custom-toast');
    if (existingToast) {
        existingToast.remove();
    }
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `custom-toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Show toast with animation
    setTimeout(() => {
        toast.classList.add('show');
    }, 10);
    
    // Hide and remove toast after 3 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

// Add toast styles dynamically
const toastStyles = document.createElement('style');
toastStyles.innerHTML = `
    .custom-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #ffffff;
        padding: 16px 24px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 9999;
        transform: translateX(400px);
        transition: transform 0.3s ease;
    }
    
    .custom-toast.show {
        transform: translateX(0);
    }
    
    .toast-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .toast-success {
        border-left: 4px solid #10b981;
    }
    
    .toast-success i {
        color: #10b981;
        font-size: 20px;
    }
    
    .toast-error {
        border-left: 4px solid #ef4444;
    }
    
    .toast-error i {
        color: #ef4444;
        font-size: 20px;
    }
    
    .toast-content span {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }
`;
document.head.appendChild(toastStyles);

// Handle delete form submission
document.addEventListener('DOMContentLoaded', function() {
    const deleteForm = document.getElementById('deleteForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const url = this.action;
            
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Data PO berhasil dihapus', 'success');
                    
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                    modal.hide();
                    
                    // Reload page after 1 second
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast('Gagal menghapus data', 'error');
                }
            })
            .catch(error => {
                showToast('Terjadi kesalahan', 'error');
            });
        });
    }
});