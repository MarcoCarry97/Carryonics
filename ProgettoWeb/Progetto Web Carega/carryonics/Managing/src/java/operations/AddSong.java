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
public class AddSong extends HttpServlet {

    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
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
    
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        try {
            String value=request.getParameter("load");
            String[] parts=value.split("-");
            int cds=Integer.parseInt(parts[0]);
            int vinils=Integer.parseInt(parts[1]);
            String name=request.getParameter("name");
            String duration=request.getParameter("duration");
            parts=duration.split(":");
            float time=Float.parseFloat(parts[0])+Float.parseFloat(parts[1])/100;
            String insertSql="Insert into songs set name=?, duration=?";
            PreparedStatement insert=connection.prepareStatement(insertSql,PreparedStatement.RETURN_GENERATED_KEYS);
            insert.setString(1,name);
            insert.setFloat(2,time);
            //out.println(insert.toString());
            insert.executeUpdate();
            //out.println(set);
            ResultSet set=insert.getGeneratedKeys();
            set.next();
            long song=set.getLong(1);
            boolean done=false;
            for(int i=0;i<cds;i++)
            {
                String check=request.getParameter("cd"+i);
                if(check!=null)
                {
                    done=true;
                    long album=Long.parseLong(check);
                    insertSql="insert into cd_song set album=?, song=?";
                    insert=connection.prepareStatement(insertSql);
                    insert.setLong(1,album);
                    insert.setLong(2,song);
                    insert.executeUpdate();
                }
                //out.println(check);
            }
            for(int i=0;i<vinils;i++)
            {
                String check=request.getParameter("vinil"+i);
                if(check!=null)
                {
                    done=true;
                    long album=Long.parseLong(check);
                    insertSql="insert into vinil_song set album=?, song=?";
                    insert=connection.prepareStatement(insertSql);
                    insert.setLong(1,album);
                    insert.setLong(2,song);
                    insert.executeUpdate();
                }
                //out.println(check);
            }
            if(done)
            {
                connection.commit();
                out.println("Song inserted in DB in selected albums!");
            }
            else
            {
               out.println("Please check almost one cd or vinil!");
               connection.rollback();
            }
            
        } catch (SQLException ex) {
            try {
                out.println(ex.getMessage());
                connection.rollback();
            } catch (SQLException ex1) {
                Logger.getLogger(AddSong.class.getName()).log(Level.SEVERE, null, ex1);
            }
             Logger.getLogger(AddSong.class.getName()).log(Level.SEVERE, null, ex);
         
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
