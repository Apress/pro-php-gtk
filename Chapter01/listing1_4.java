import javax.swing.*;

public class listing1_4 {

    public static void createAndShowGUI() {
	JFrame frame = new JFrame();
	frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
	frame.setVisible(true);
    }

    public static void main(String[] args) {
	  javax.swing.SwingUtilities.invokeLater(
						 createAndShowGUI();
						 );
	  createAndShowGUI();
    }
}
