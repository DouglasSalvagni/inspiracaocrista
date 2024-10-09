
(function () {
    class DragAndDrop {
        constructor(containerSelector) {
            this.containers = document.querySelectorAll(containerSelector);
            this.draggedElement = null;
            this.draggedClone = null;
            this.initializeDragAndDrop();
        }
    
        initializeDragAndDrop() {
            this.containers.forEach(container => {
                container.addEventListener('dragstart', this.handleDragStart.bind(this), false);
                container.addEventListener('dragover', this.handleDragOver.bind(this), false);
                container.addEventListener('drop', this.handleDrop.bind(this), false);
                container.addEventListener('dragend', this.handleDragEnd.bind(this), false);
            });
        }
    
        handleDragStart(e) {
            const target = e.target.closest('[data-lead-id]');
            if (target) {
                e.dataTransfer.setData('text/plain', target.dataset.leadId);
                e.dataTransfer.effectAllowed = 'move';
    
                // Clone the element being dragged
                this.draggedClone = target.cloneNode(true);
                this.draggedClone.style.position = 'absolute';
                this.draggedClone.style.top = '-9999px'; // Hide the clone initially
                document.body.appendChild(this.draggedClone);
                
                e.dataTransfer.setDragImage(this.draggedClone, 0, 0); // Use the clone as the drag image
    
                this.draggedElement = target;
                target.classList.add('dragging');
            }
        }
    
        handleDragOver(e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
        }
    
        handleDrop(e) {
            e.preventDefault();
            const leadId = e.dataTransfer.getData('text/plain');
            const newStatus = e.currentTarget.dataset.status;
            const draggedElement = this.draggedElement;
    
            if (draggedElement) {
                e.currentTarget.appendChild(draggedElement);
                this.updateLeadStatus(leadId, newStatus);
            }
        }
    
        handleDragEnd(e) {
            if (this.draggedElement) {
                this.draggedElement.classList.remove('dragging');
            }
            if (this.draggedClone) {
                document.body.removeChild(this.draggedClone);
                this.draggedClone = null;
            }
        }
    
        updateLeadStatus(leadId, newStatus) {
            console.log(`Updating lead status: ${leadId} to new status: ${newStatus}`);
    
            fetch(sysUrls.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'update_lead_status',
                    lead_id: leadId,
                    new_status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Lead status updated successfully.');
                } else {
                    console.log('Error updating lead status:', data.data);
                }
            })
            .catch(error => {
                console.error('AJAX error:', error);
            });
        }
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        new DragAndDrop('.sortable');
    });

})();
