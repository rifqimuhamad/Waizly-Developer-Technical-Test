import java.time.format.DateTimeFormatter;
import java.time.LocalTime;

public class Basic_Test3{

    public static void main(String[] args) {
        String s = "12:01:00PM";
        System.out.println(timeConversion(s));
    }

    static String timeConversion(String s) {
        DateTimeFormatter inputT = DateTimeFormatter.ofPattern("hh:mm:ssa");
        LocalTime time = LocalTime.parse(s, inputT);

        DateTimeFormatter outT = DateTimeFormatter.ofPattern("HH:mm:ss");
        return time.format(outT);
    }
}
