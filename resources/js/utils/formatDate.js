import dayjs from "dayjs";

export default function (value) {
    return dayjs(value).format("YYYY/MM/DD HH:mm");
}
