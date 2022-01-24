/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package model;

import javafx.application.Application;
import javafx.scene.Group;
import javafx.scene.Scene;
import javafx.stage.Stage;

/**
 *
 * @author Gabriel
 */
public class Roanimob extends Application {
    
    public static String templateID = "templateID";
    public static String template = "/view/template.fxml";
    public static String locadorImovelID = "locadorImovelID";
    public static String locadorImovel = "/view/locadorImovel.fxml";
    
    @Override
    public void start(Stage stage) throws Exception {
        
        MainContainer mainContainer = new MainContainer();
        // Have to create one instance for each screen;
        mainContainer.loadScreen(Roanimob.templateID, Roanimob.template); 
        mainContainer.loadScreen(Roanimob.locadorImovelID, Roanimob.locadorImovel); 
        
        // This is the main screen, the background template.
        mainContainer.setScreen(template);
        
        Group root = new Group();
        root.getChildren().addAll(mainContainer);
        Scene scene = new Scene(root);
        stage.setScene(scene);
        stage.show();
    }

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        launch(args);
    }
    
}
