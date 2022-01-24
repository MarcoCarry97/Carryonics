/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package operations;

import java.io.IOException;
import java.io.PrintWriter;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

/**
 *
 * @author Marco-PC
 */
public class AddActor extends HttpServlet {

    
     private Connection connection;
    private PreparedStatement control;
    private String sql;
    
    @Override
    public void init()
    {
        try {
            Class.forName("com.mysql.jdbc.Driver");
            connection=DriverManager.getConnection("jdbc:mysql://localhost:3306/carryonics","root","");
            sql="select id,name,amount from products where name=?";
            control=connection.prepareStatement(sql);
           connection.setAutoCommit(false);
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(Insert.class.getName()).log(Level.SEVERE, null, ex);
        } catch (SQLException ex) {
            Logger.getLogger(Insert.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        try {
            /* TODO output your page here. You may use following sample code. */
            String name=request.getParameter("name");
            String surname=request.getParameter("surname");
            String insertSql="insert into actors set name=?, surname=?";
            PreparedStatement insert=connection.prepareStatement(insertSql,PreparedStatement.RETURN_GENERATED_KEYS);
            insert.setString(1,name);
            insert.setString(2,surname);
            insert.executeUpdate();
            ResultSet set=insert.getGeneratedKeys();
            set.first();
            long actor=set.getLong(1);
            int num=Integer.parseInt(request.getParameter("load"));
            boolean checked=false;
            for(int i=0;i<num;i++)
            {
                String check=request.getParameter(String.valueOf(i));
                if(check!=null)
                {
                    checked=true;
                    long film=Long.parseLong(check);
                    insertSql="insert into film_actor set film=?, actor=?";
                    insert=connection.prepareStatement(insertSql);
                    insert.setLong(1,film);
                    insert.setLong(2, actor);
                    insert.executeUpdate();
                }
            }
            if(checked)
            {
                connection.commit();
                out.println("actor inserted in the chosen films!");
            }
            else
            {
                out.println("Please check almost a film!");
                connection.rollback();
            }
        } catch (SQLException ex) {
            try {
                out.println(ex.getMessage());
                connection.rollback();
            } catch (SQLException ex1) {
                Logger.getLogger(AddActor.class.getName()).log(Level.SEVERE, null, ex1);
            }
             Logger.getLogger(AddActor.class.getName()).log(Level.SEVERE, null, ex);
         } finally {
            out.close();
        }
    }

    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Handles the HTTP <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
    public String getServletInfo() {
        return "Short description";
    }// </editor-fold>

}
