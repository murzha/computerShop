export class Notification {
    constructor() {
        this.container = this.createContainer();
        this.queue = [];
        this.isProcessing = false;
    }

    createContainer() {
        const container = document.createElement('div');
        container.className = 'notification-container';
        document.body.appendChild(container);
        return container;
    }

    show(message, type = 'info', duration = 3000) {
        this.queue.push({message, type, duration});

        if (!this.isProcessing) {
            this.processQueue();
        }
    }

    async processQueue() {
        if (this.queue.length === 0) {
            this.isProcessing = false;
            return;
        }

        this.isProcessing = true;
        const {message, type, duration} = this.queue.shift();

        const notification = this.createNotification(message, type);
        this.container.appendChild(notification);

        // Trigger animation
        setTimeout(() => {
            notification.classList.add('notification--visible');
        }, 10);

        // Wait for duration
        await new Promise(resolve => setTimeout(resolve, duration));

        // Hide notification
        notification.classList.remove('notification--visible');
        notification.addEventListener('transitionend', () => {
            notification.remove();
            this.processQueue();
        });
    }

    createNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification notification--${type}`;

        const content = document.createElement('div');
        content.className = 'notification__content';

        // Add icon based on type
        const icon = document.createElement('i');
        icon.className = `bi notification__icon ${this.getIconClass(type)}`;
        content.appendChild(icon);

        const messageElement = document.createElement('div');
        messageElement.className = 'notification__message';
        messageElement.textContent = message;
        content.appendChild(messageElement);

        notification.appendChild(content);

        // Add close button
        const closeButton = document.createElement('button');
        closeButton.className = 'notification__close';
        closeButton.innerHTML = '<i class="bi bi-x"></i>';
        closeButton.addEventListener('click', () => {
            notification.classList.remove('notification--visible');
            setTimeout(() => notification.remove(), 300);
        });
        notification.appendChild(closeButton);

        return notification;
    }

    getIconClass(type) {
        const icons = {
            success: 'bi-check-circle',
            error: 'bi-x-circle',
            warning: 'bi-exclamation-circle',
            info: 'bi-info-circle'
        };
        return icons[type] || icons.info;
    }

    // Convenience methods
    success(message, duration) {
        this.show(message, 'success', duration);
    }

    error(message, duration) {
        this.show(message, 'error', duration);
    }

    warning(message, duration) {
        this.show(message, 'warning', duration);
    }

    info(message, duration) {
        this.show(message, 'info', duration);
    }
}
