export default class GeolocationService {
    static STORAGE_KEY = 'geolog_location';

    static getCurrentPosition() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject(new Error('位置情報に対応していません。'));
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    resolve({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                    });
                },
                (error) => {
                    reject(error);
                },
                {
                    maximumAge: 60000,
                }
            );
        });
    }

    // 保存済みの位置情報を取得
    static getSavedPosition() {
        const saved = localStorage.getItem(this.STORAGE_KEY);

        return saved ? JSON.parse(saved) : null;
    }

    // 位置情報を保存
    static savePosition(position) {
        const location = {
            ...position,
            updatedAt: new Date().toISOString(),
        };

        localStorage.setItem(
            this.STORAGE_KEY,
            JSON.stringify(location)
        );

        return location;
    }

    // 現在地を取得して保存
    static async updatePosition() {
        const position = await this.getCurrentPosition();

        return this.savePosition(position);
    }
}