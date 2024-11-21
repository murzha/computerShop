export class EventEmitter {
    constructor() {
        this.events = {};
    }

    on(eventName, callback) {
        if (!this.events[eventName]) {
            this.events[eventName] = [];
        }
        this.events[eventName].push(callback);

        return () => this.off(eventName, callback);
    }

    off(eventName, callback) {
        if (!this.events[eventName]) return;

        this.events[eventName] = this.events[eventName]
            .filter(cb => cb !== callback);
    }

    emit(eventName, data) {
        if (!this.events[eventName]) return;

        this.events[eventName].forEach(callback => {
            callback(data);
        });
    }

    once(eventName, callback) {
        const onceCallback = (data) => {
            callback(data);
            this.off(eventName, onceCallback);
        };

        this.on(eventName, onceCallback);
    }
}
