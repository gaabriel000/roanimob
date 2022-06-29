package controller;

import model.MainContainer;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.fxml.Initializable;

/**
 * FXML Controller class
 *
 * @author gabriel
 */
public class LocadorImovelController implements Initializable, ScreenInterface {

    MainContainer parentController;
    
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }

    @Override
    public void setScreenParent(MainContainer mainController) {
        parentController = mainController;
    }
    
}
