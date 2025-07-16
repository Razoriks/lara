export default function (value) {
    const formatter = new Intl.NumberFormat("ru-RU", {
        style: "currency",
        currency: "RUB",
        // maximumFractionDigits: 3,
    });

    const preparedVal = value / 100;

    return formatter.format(preparedVal);
}
